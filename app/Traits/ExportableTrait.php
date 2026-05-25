<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportableTrait
{
    /**
     * Exporte les données en CSV
     * 
     * @param $data Collection des modèles
     * @param array $columnMapping ['label' => 'colonne', ...] 
     * @param string $filename Nom du fichier sans extension
     * @return StreamedResponse
     */
    public function exportToCSV($data, $columnMapping, $filename = 'export')
    {
        $response = new StreamedResponse(function () use ($data, $columnMapping) {
            $handle = fopen('php://output', 'w');
            
            // En-tête (labels)
            fputcsv($handle, array_keys($columnMapping), ';');
            
            // Données
            foreach ($data as $item) {
                $row = [];
                foreach ($columnMapping as $column) {
                    $value = $this->getNestedValue($item, $column);
                    $row[] = $value;
                }
                fputcsv($handle, $row, ';');
            }
            
            fclose($handle);
        });
        
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '_' . date('Y-m-d_H-i-s') . '.csv"');
        $response->headers->set('Content-Transfer-Encoding', 'UTF-8');
        
        return $response;
    }
    
    /**
     * Récupère une valeur imbriquée (ex: candidat.nom)
     */
    private function getNestedValue($object, $key)
    {
        $keys = explode('.', $key);
        $value = $object;
        
        foreach ($keys as $k) {
            if ($value === null) return '';
            if (is_object($value)) {
                if (method_exists($value, $k)) {
                    $value = $value->$k();
                } elseif (property_exists($value, $k)) {
                    $value = $value->$k;
                } else {
                    return '';
                }
            } elseif (is_array($value) && isset($value[$k])) {
                $value = $value[$k];
            } else {
                return '';
            }
        }
        
        return $value ?? '';
    }
}

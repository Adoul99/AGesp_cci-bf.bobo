Découpe le produit en **thèmes et sous-thèmes métier** (WBS) et range les tâches
retenues dans les feuilles. Écris/mets à jour `.solo/idee/domaines/<ideation>.md`
(un fichier par idéation). Étape 5 de la chaîne d'idéation (le regroupement,
ex-Sitemap).

Front-matter OBLIGATOIRE (identifie l'idéation) :
```yaml
---
ideation: <slug-idéation>
date: AAAA-MM-JJ
---
```

Méthode imposée : **DDD — bounded contexts**, en **arbre** (WBS). Un thème peut
avoir des **sous-thèmes** ; on descend jusqu'à des feuilles cohérentes. L'arbre ne
contient **que des thèmes** — **jamais de tâches** comme nœuds.

Règle imposée : **MECE** au niveau des **feuilles**.
- **Mutuellement exclusif** : chaque tâche retenue est rangée dans **une seule**
  feuille (thème sans sous-thème).
- **Collectivement exhaustif** : **toutes** les tâches `retenu: true` du How-How
  sont rangées dans une feuille (aucune orpheline).
- Un thème qui a des **sous-thèmes ne porte PAS de tâches directes** (les tâches
  vivent sur les feuilles). Solo vérifie tout ça et affiche les écarts — vise zéro.

Structure du fichier `domaines.md` :
- `::: titre` puis `::: analyse` (le principe de découpage, en une phrase).
- **Un bloc `::: theme`** par thème/sous-thème, en props :
  `{ code: th-<slug>, titre, parent?: <code-parent>, taches?: [<code-action>, …] }`.
  - `parent` absent = **thème racine** ; sinon = le `code` du thème parent.
  - `taches` **uniquement sur une feuille** (thème sans sous-thème) — les `code`
    des blocs `::: action` retenus (ex. `hh-cta-sticky`).
  - Le **corps markdown** décrit le thème (responsabilité, frontière) : c'est ce
    qui s'affiche **au clic** sur la tuile dans Solo.

> La **priorisation** (impact/effort) n'est **pas** portée par les thèmes : elle
> vit sur les tâches (`::: action`, `/solo-howhow`). L'onglet Priorités affiche les
> tâches et permet de **filtrer par thème** (un thème parent agrège ses sous-thèmes).

La représentation dans Solo est un **WBS hiérarchique** (Produit → thèmes →
sous-thèmes). Chaque tuile est cliquable ; le clic ouvre la description + les
tâches (une feuille montre les siennes, un thème parent agrège celles de ses
sous-thèmes).

Exemple :
```
::: theme
---
code: th-achat
titre: Achat & Conversion
---
Tout le parcours d'achat sur le site.
:::

::: theme
---
code: th-paiement
titre: Paiement
parent: th-achat
taches: [hh-mobile-money, hh-idempotence, hh-reconciliation]
---
Encaissement et transactions : mobile money, réconciliation, échecs/timeouts.
**Frontière** : ne gère pas le prix affiché (→ Catalogue) ni la livraison.
:::

::: theme
---
code: th-checkout
titre: Checkout
parent: th-achat
taches: [hh-cta-sticky, hh-tunnel-court]
---
Tunnel de commande : panier → confirmation. CTA dominant, étapes minimales.
:::
```

Codes (`code`) **préfixés par l'idéation** pour rester uniques dans le projet.
Ne touche qu'à `.solo/idee/domaines/`. Visible dans l'onglet **Domaines**.

Périmètre (optionnel) : $ARGUMENTS

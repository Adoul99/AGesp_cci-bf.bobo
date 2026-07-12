<x-layouts::app title="Nouvelle Inscription">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap');

        :root {
            --cci-green: #1a6b3a;
            --cci-green-deep: #0e4525;
            --cci-red: #c0281e;
            --cci-red-dark: #8b1a12;
            --cci-gold: #d4a017;
            --cci-gold-light: #f0c94a;
        }

        body { font-family: 'Nunito', sans-serif; }

        .form-hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #0a2f19 0%, #0e4525 30%, #1a6b3a 55%, #16532f 75%, #0a2f19 100%);
            margin: -1.25rem -1.25rem 0;
            padding: 3rem 1.5rem 5rem;
            color: #fff;
        }

        /* ── Formes décoratives pour casser le plat vert ── */
        .form-hero::before {
            content: '';
            position: absolute; top: -120px; right: -120px;
            width: 420px; height: 420px; border-radius: 50%;
            background: radial-gradient(circle, rgba(192,40,30,0.35) 0%, transparent 70%);
        }
        .form-hero::after {
            content: '';
            position: absolute; bottom: -150px; left: -100px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(212,160,23,0.28) 0%, transparent 70%);
        }
        .deco-stripe {
            position: absolute; top: 0; left: 0; right: 0; height: 6px;
            background: linear-gradient(90deg, var(--cci-red) 0%, var(--cci-red) 33%, var(--cci-gold) 33%, var(--cci-gold) 66%, var(--cci-green) 66%, var(--cci-green) 100%);
            z-index: 5;
        }
        .content-inner { position: relative; z-index: 2; }

        .form-title-block { max-width: 780px; margin: 0 auto 3rem; }
        .form-title-block .eyebrow {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em;
            color: var(--cci-gold-light); margin-bottom: 0.9rem;
            background: rgba(192,40,30,0.25); padding: 0.4rem 0.9rem; border-radius: 20px;
            border: 1px solid rgba(212,160,23,0.35);
        }
        .form-title-block .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--cci-red); }
        .form-title-block h1 {
            font-size: 2.5rem; font-weight: 900; margin: 0 0 0.6rem; letter-spacing: -0.01em;
            line-height: 1.15;
            background: linear-gradient(90deg, #fff 30%, var(--cci-gold-light) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .form-title-block p { font-size: 1rem; color: rgba(255,255,255,0.78); margin: 0; max-width: 560px; }

        .qgroup {
            max-width: 780px; margin: 0 auto 2rem;
            background: rgba(255,255,255,0.055);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 18px;
            padding: 1.75rem 2rem;
            backdrop-filter: blur(6px);
        }
        .qnum {
            display: inline-flex; align-items: center; gap: 0.7rem;
            font-size: 1.15rem; font-weight: 800; color: #fff; margin-bottom: 1.25rem;
        }
        .qnum .n {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, var(--cci-red) 0%, var(--cci-red-dark) 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem; flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(192,40,30,0.4);
        }
        .qnum span.sub {
            font-size: 0.73rem; font-weight: 600; color: rgba(255,255,255,0.5);
            text-transform: none; margin-left: 0.35rem;
        }

        .qrow { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; }

        .field-box {
            border: 1.5px solid rgba(255,255,255,0.22);
            border-radius: 11px;
            background: rgba(0,0,0,0.15);
            padding: 0.2rem 1.1rem;
            transition: border-color 0.18s, background 0.18s;
        }
        .field-box:hover { border-color: rgba(255,255,255,0.4); }
        .field-box:focus-within {
            border-color: var(--cci-gold-light);
            background: rgba(212,160,23,0.1);
            box-shadow: 0 0 0 3px rgba(212,160,23,0.15);
        }
        .field-box input, .field-box select {
            width: 100%; background: transparent; border: none; outline: none;
            color: #fff; font-size: 1.02rem; font-weight: 600; padding: 0.8rem 0;
            font-family: inherit;
        }
        .field-box input::placeholder { color: rgba(255,255,255,0.38); font-weight: 500; }
        .field-box select { color: #fff; }
        .field-box select option { color: #1a1a1a; }
        .field-box input[type="date"] { color-scheme: dark; }

        .field-box.file-box { display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 1.1rem; }
        .field-box.file-box i { color: var(--cci-gold-light); font-size: 1.05rem; }
        .field-box.file-box input[type="file"] { padding: 0.45rem 0; font-size: 0.88rem; }
        .field-box.file-box input[type="file"]::file-selector-button {
            background: rgba(255,255,255,0.14); color: #fff; border: none;
            padding: 0.4rem 0.85rem; border-radius: 7px; font-weight: 700; font-size: 0.8rem;
            margin-right: 0.8rem; cursor: pointer;
        }

        /* ── Libellé au-dessus de chaque champ de pièce jointe, pour indiquer quel document déposer ── */
        .file-label {
            font-size: 0.73rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            color: rgba(255,255,255,0.6); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.3rem;
        }
        .file-label .req { color: var(--cci-gold-light); }
        .file-label .opt { color: rgba(255,255,255,0.4); font-weight: 600; text-transform: none; letter-spacing: 0; }

        .hint-line { font-size: 0.8rem; color: rgba(255,255,255,0.55); margin-top: 0.65rem; display: flex; align-items: center; gap: 0.4rem; }
        .hint-line.warn { color: var(--cci-gold-light); font-weight: 700; }

        /* ── Âge calculé automatiquement à partir de la date de naissance ── */
        .age-tag {
            display: inline-flex; align-items: center; gap: 0.4rem; margin-top: 0.7rem;
            padding: 0.35rem 0.9rem; background: rgba(255,255,255,0.1);
            border-radius: 20px; font-size: 0.78rem; font-weight: 700; color: #fff;
        }
        .age-tag.ok { background: rgba(26,107,58,0.35); color: #c9f2d8; }
        .age-tag.ko { background: rgba(192,40,30,0.35); color: #ffd6d1; }

        .amount-highlight {
            border-color: rgba(212,160,23,0.5);
            background: linear-gradient(135deg, rgba(212,160,23,0.12) 0%, rgba(255,255,255,0.04) 100%);
        }
        .amount-highlight .field-box { border-color: var(--cci-gold-light); background: rgba(0,0,0,0.2); }
        .amount-highlight input { font-size: 1.45rem; font-weight: 900; color: var(--cci-gold-light); }
        .amount-tag {
            display: inline-flex; align-items: center; gap: 0.4rem; margin-top: 0.7rem;
            padding: 0.35rem 0.9rem; background: rgba(255,255,255,0.1);
            border-radius: 20px; font-size: 0.78rem; font-weight: 700; color: #fff;
        }

        .submit-zone {
            max-width: 780px; margin: 0.5rem auto 0; padding: 1.5rem 2rem 0;
            display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;
        }
        .btn-submit-hero {
            background: linear-gradient(135deg, var(--cci-gold-light) 0%, var(--cci-gold) 100%);
            color: var(--cci-green-deep);
            padding: 1rem 2.5rem; border-radius: 12px; border: none;
            font-weight: 900; font-size: 1rem; cursor: pointer;
            box-shadow: 0 8px 24px rgba(212,160,23,0.4);
            transition: transform 0.15s;
        }
        .btn-submit-hero:hover { transform: translateY(-2px); }
        .btn-cancel-hero {
            color: rgba(255,255,255,0.75); text-decoration: none; font-weight: 700; font-size: 0.92rem;
            padding: 1rem 0.5rem;
        }
        .btn-cancel-hero:hover { color: #fff; }

        .error-hero {
            max-width: 780px; margin: 0 auto 2rem;
            background: rgba(192,40,30,0.22); border: 1.5px solid rgba(192,40,30,0.55);
            border-radius: 14px; padding: 1.25rem 1.5rem; color: #ffe0dc;
            position: relative; z-index: 2;
        }
        .error-hero strong { color: #fff; }

        @media (max-width: 640px) {
            .form-title-block h1 { font-size: 1.8rem; }
            .qgroup { padding: 1.25rem 1.25rem; }
        }
    </style>

    <div class="form-hero">
        <div class="deco-stripe"></div>
        <div class="content-inner">

            <div class="form-title-block">
                <div class="eyebrow"><span class="eyebrow-dot"></span> CCI-BF — Bobo-Dioulasso</div>
                <h1>Nouvelle Inscription</h1>
                <p>Formulaire de saisie au guichet, à remplir en présence du candidat.</p>
            </div>

            @if ($errors->any())
                <div class="error-hero">
                    <strong>Corrigez les points suivants :</strong>
                    <ul style="margin: 0.5rem 0 0 1.2rem;">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('inscriptions.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="qgroup">
                    <div class="qnum"><span class="n">1</span> Identité</div>
                    <div class="qrow">
                        <div class="field-box"><input type="text" name="nom" value="{{ old('nom') }}" placeholder="Nom de famille" required></div>
                        <div class="field-box"><input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Prénom" required></div>
                    </div>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">2</span> Naissance</div>
                    <div class="qrow">
                        <div class="field-box"><input type="date" id="dateNaissance" name="dateNaissance" value="{{ old('dateNaissance') }}" min="{{ now()->subYears(90)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" required></div>
                        <div class="field-box"><input type="text" name="lieuNaissance" value="{{ old('lieuNaissance') }}" placeholder="Lieu de naissance" required></div>
                    </div>
                    {{-- ✅ Rappel + âge calculé automatiquement --}}
                    <div class="hint-line warn">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Le candidat doit avoir au moins 21 ans à la date d'inscription.
                    </div>
                    <span id="ageTag" class="age-tag" style="display:none;"></span>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">3</span> Numéro de téléphone</div>
                    <div class="field-box"><input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="+226 XX XX XX XX" required></div>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">4</span> Adresse email <span class="sub">facultatif</span></div>
                    <div class="field-box"><input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@mail.com"></div>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">5</span> Permis C <span class="sub">6 mois d'ancienneté minimum</span></div>
                    <div class="qrow" style="margin-bottom: 1.25rem;">
                        <div class="field-box"><input type="text" name="numeroPermisC" value="{{ old('numeroPermisC') }}" placeholder="Numéro du permis C" required></div>
                        <div class="field-box"><input type="text" name="lieuDelivrancePermisC" value="{{ old('lieuDelivrancePermisC') }}" placeholder="Lieu de délivrance" required></div>
                    </div>
                    <div class="field-box"><input type="date" id="dateDelivrancePermisC" name="dateDelivrancePermisC" value="{{ old('dateDelivrancePermisC') }}" min="{{ now()->subYears(60)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" required></div>
                    <div class="hint-line warn">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        Doit être antérieure au {{ \Carbon\Carbon::now()->subMonths(6)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">6</span> Catégorie de permis</div>
                    <div class="field-box">
                        <select name="categoriePermis_id" required>
                            <option value="">-- Choisir --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoriePermis_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nomCategorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="qgroup">
                    <div class="qnum"><span class="n">7</span> Date d'inscription</div>
                    <div class="field-box"><input type="date" name="dateInscription" value="{{ old('dateInscription', now()->toDateString()) }}" required></div>
                </div>

                <div class="qgroup amount-highlight">
                    <div class="qnum"><span class="n">8</span> Montant encaissé <span class="sub">espèces</span></div>
                    <div class="field-box"><input type="number" name="montantPaiement" value="{{ old('montantPaiement', 135000) }}" min="1" required></div>
                    <span class="amount-tag"><i class="bi bi-check-circle-fill"></i> Tarif standard : 135 000 FCFA</span>
                </div>

                {{-- ✅ Chaque champ indique maintenant clairement quelle pièce y déposer --}}
                <div class="qgroup">
                    <div class="qnum"><span class="n">9</span> Pièces jointes</div>
                    <div class="qrow">
                        <div>
                            <div class="file-label">CNIB <span class="req">*</span></div>
                            <div class="field-box file-box"><i class="bi bi-file-earmark-text"></i><input type="file" name="cnib" required></div>
                        </div>
                        <div>
                            <div class="file-label">Photo d'identité <span class="req">*</span></div>
                            <div class="field-box file-box"><i class="bi bi-person-badge"></i><input type="file" name="photo_identite" required></div>
                        </div>
                    </div>
                    <div class="qrow" style="margin-top: 1.25rem;">
                        <div>
                            <div class="file-label">Certificat médical <span class="req">*</span></div>
                            <div class="field-box file-box"><i class="bi bi-heart-pulse"></i><input type="file" name="certificat_medical" required></div>
                        </div>
                        <div>
                            <div class="file-label">Acte de naissance <span class="req">*</span></div>
                            <div class="field-box file-box"><i class="bi bi-file-earmark-person"></i><input type="file" name="acte_naissance" required></div>
                        </div>
                    </div>
                    <div class="qrow" style="margin-top: 1.25rem;">
                        <div>
                            <div class="file-label">Copie du permis C <span class="opt">(optionnel)</span></div>
                            <div class="field-box file-box"><i class="bi bi-card-checklist"></i><input type="file" name="permis_c"></div>
                        </div>
                    </div>
                    <div class="hint-line">CNIB, Photo d'identité, Certificat médical et Acte de naissance sont obligatoires.</div>
                </div>

                <div class="submit-zone">
                    <button type="submit" class="btn-submit-hero">✓ Enregistrer l'inscription</button>
                    <a href="{{ route('inscriptions.index') }}" class="btn-cancel-hero">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Empêche la saisie d'années invalides (ex: 5 chiffres) sur tous les champs date du formulaire --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input[type="date"]').forEach(function (input) {
                input.addEventListener('input', function () {
                    if (!input.value) { input.setCustomValidity(''); return; }
                    const annee = input.value.split('-')[0];
                    const anneeCourante = new Date().getFullYear();
                    if (annee.length !== 4 || Number(annee) > anneeCourante + 1 || Number(annee) < 1900) {
                        input.setCustomValidity('Année invalide.');
                    } else {
                        input.setCustomValidity('');
                    }
                });
            });
        });
    </script>

    {{-- ✅ Calcule et affiche l'âge du candidat dès qu'il saisit sa date de naissance --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('dateNaissance');
            const ageTag = document.getElementById('ageTag');
            if (!dateInput || !ageTag) return;

            function majAge() {
                if (!dateInput.value) { ageTag.style.display = 'none'; return; }

                // ✅ Garde-fou : rejette les années saisies avec un nombre de chiffres anormal
                const anneeSaisie = dateInput.value.split('-')[0];
                const anneeCourante = new Date().getFullYear();
                if (anneeSaisie.length !== 4 || Number(anneeSaisie) > anneeCourante || Number(anneeSaisie) < anneeCourante - 90) {
                    ageTag.style.display = 'inline-flex';
                    ageTag.className = 'age-tag ko';
                    ageTag.innerHTML = '<i class="bi bi-x-circle-fill"></i> Date de naissance invalide';
                    dateInput.setCustomValidity('Date de naissance invalide.');
                    return;
                }
                dateInput.setCustomValidity('');

                const naissance = new Date(dateInput.value);
                const aujourdHui = new Date();
                let age = aujourdHui.getFullYear() - naissance.getFullYear();
                const moisDiff = aujourdHui.getMonth() - naissance.getMonth();
                if (moisDiff < 0 || (moisDiff === 0 && aujourdHui.getDate() < naissance.getDate())) {
                    age--;
                }

                ageTag.style.display = 'inline-flex';
                if (age >= 21) {
                    ageTag.className = 'age-tag ok';
                    ageTag.innerHTML = '<i class="bi bi-check-circle-fill"></i> Âge : ' + age + ' ans — condition remplie';
                } else {
                    ageTag.className = 'age-tag ko';
                    ageTag.innerHTML = '<i class="bi bi-x-circle-fill"></i> Âge : ' + age + ' ans — le candidat doit avoir au moins 21 ans';
                }
            }

            dateInput.addEventListener('change', majAge);
            dateInput.addEventListener('input', majAge);
            majAge();
        });
    </script>
</x-layouts::app>
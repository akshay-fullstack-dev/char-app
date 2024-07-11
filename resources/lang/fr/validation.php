<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

'accepted' => ':attribute doit être accepté.',
'active_url' => ':attribute n\'est pas une adresse valide.',
'after' => ':attribute doit être une date après :date.',
'after_or_equal' => ':attribute doit être une date après ou égale à :date.',
'alpha' => ':attribute ne peut contenir que des lettres.',
'alpha_dash' => ':attribute ne peut contenir que des lettres, chiffres, tirets et 
traits de soulignement.',
'alpha_num' => ':attribute ne peut contenir que des lettres et des chiffres.',
'array' => ':attribute doit être un tableau de données.',
'before' => ':attribute doit être une date avant :date.',
'before_or_equal' => ':attribute doit être une date avant ou égale à :date.',
'between' => [
'numeric' => ':attribute doit être entre :min et :max.',
'file' => ':attribute doit être entre :min et :max kilo-octets.',
'string' => ':attribute doit être entre :min et :max charactères.',
'array' => ':attribute doit contenir entre :min et :max items.',
],
'boolean' => 'Le champ :attribute doit être vrai ou faux.',
'confirmed' => 'La confirmation de :attribute ne correspond pas.',
'date' => ':attribute n\'est pas une date valide.',
'date_equals' => ':attribute doit être une date égale à :date.',
'date_format' => ':attribute ne correspond pas au format :format.',
'different' => ':attribute et :other doivent être différents.',
'digits' => ':attribute doit contenir :digits chiffres.',
'digits_between' => ':attribute doit être entre :min et :max chiffres.',
'dimensions' => 'Les dimensions de :attribute sont invalides.',
'distinct' => 'Le champ :attribute est un doublon.',
'email' => ':attribute doit être une adresse email valide.',
'ends_with' => ':attribute doit se terminer avec une des valeurs suivantes: :values.',
'exists' => 'L\'item :attribute sélectionné est invalide.',
'file' => ':attribute doit être un fichier.',
'filled' => 'Le champ :attribute doit avoir une valeur.',
'gt' => [
'numeric' => ':attribute doit être supérieur à :value.',
'file' => ':attribute doit être supérieur à :value kilobytes.',
'string' => ':attribute doit contenir plus de :value charactères.',
'array' => ':attribute doit contenir plus de :value items.',
],
'gte' => [
'numeric' => ':attribute doit être supérieur ou égal à :value.',
'file' => ':attribute doit être supérieur ou égal à :value kilo-octets.',
'string' => ':attribute doit être supérieur ou égal à :value charactères.',
'array' => ':attribute doit contenir :value items ou plus.',
],
'image' => ':attribute doit être une image.',
'in' => 'L\'item :attribute sélectionné est invalide.',
'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
'integer' => ':attribute doit être un nombre entier.',
'ip' => ':attribute doit être une adresse IP valide.',
'ipv4' => ':attribute doit être une adresse IPv4 valide.',
'ipv6' => ':attribute doit être une adresse IPv6 valide.',
'json' => ':attribute doit être une chaîne JSON valide.',
'lt' => [
'numeric' => ':attribute doit être inférieur à :value.',
'file' => ':attribute doit être inférieur à :value kilo-octets.',
'string' => ':attribute doit être inférieur à :value charactères.',
'array' => ':attribute doit contenir moins de :value items.',
],
'lte' => [
'numeric' => ':attribute doit être inférieur ou égal à :value.',
'file' => ':attribute doit être inférieur ou égal à :value kilo-octets.',
'string' => ':attribute doit être inférieur ou égal à :value charactères.',
'array' => ':attribute ne doit pas contenir plus de :value items.',
],
'max' => [
'numeric' => ':attribute ne doit pas être supérieur à :max.',
'file' => ':attribute ne doit pas être supérieur à :max kilo-octets.',
'string' => ':attribute ne doit pas être supérieur à :max charactères.',
'array' => ':attribute ne doit pas contenir plus de :max items.',
],
'mimes' => ':attribute doit être un fichier de type: :values.',
'mimetypes' => ':attribute doit être un fichier de type: :values.',
'min' => [
'numeric' => ':attribute doit être au moins :min.',
'file' => ':attribute doit être au moins :min kilo-octets.',
'string' => ':attribute doit être au moins :min charactères.',
'array' => ':attribute doit contenir au moins :min items.',
],
'not_in' => 'L\'item :attribute sélectionné est invalide.',
'not_regex' => 'Le format de :attribute est invalide.',
'numeric' => ':attribute doit être un nombre.',
'password' => 'Le mot de passe est incorrect.',
'present' => 'Le champ :attribute doit être présent.',
'regex' => 'Le format de :attribute est invalide.',
'required' => 'Le champ :attribute est obligatoire.',
'required_if' => 'Le champ :attribute est obligatoire quand :other égale :value.',
'required_unless' => 'Le champ :attribute est obligatoire sauf si :other est compris entre :values.',
'required_with' => 'Le champ :attribute est obligatoire lorsque :values est présent.',
'required_with_all' => 'Le champ :attribute est obligatoire lorsque :values sont présents.',
'required_without' => 'Le champ :attribute est obligatoire lorsque :values est absent.',
'required_without_all' => 'Le champ :attribute est obligatoire lorsque aucune des items :values ne sont présents.',
'same' => ':attribute et :other doivent correspondre.',
'size' => [
'numeric' => ':attribute doit être :size.',
'file' => ':attribute doit être :size kilo-octets.',
'string' => ':attribute doit être :size charactères.',
'array' => ':attribute doit contenir :size items.',
],
'starts_with' => ':attribute doit commencer avec une des valeurs suivantes: :values.',
'string' => ':attribute doit être une chaîne de données.',
'timezone' => ':attribute doit être une zone valide.',
'unique' => ':attribute est déjà pris.',
'uploaded' => 'Le chargement de :attribute a échoué.',
'url' => 'Le format de :attribute est invalide.',
'uuid' => ':attribute doit être un identifiant UUID valide.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];

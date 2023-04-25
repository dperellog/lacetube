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

    'accepted'             => 'El camp :attribute s\'ha d\'acceptar.',
    'active_url'           => 'El camp :attribute no és una adreça web vàlida.',
    'after'                => 'El camp :attribute ha de ser una data posterior a :date.',
    'after_or_equal'       => 'El camp :attribute ha de ser una data posterior o igual a :date.',
    'alpha'                => 'El camp :attribute només pot contenir lletres.',
    'alpha_dash'           => 'El camp :attribute només pot contenir lletres, números i punts.',
    'alpha_num'            => 'El camp :attribute només pot contenir lletres i números.',
    'array'                => 'El camp :attribute ha de ser un array.',
    'before'               => 'El camp :attribute ha de ser una data anterior a :date.',
    'before_or_equal'      => 'El camp :attribute ha de ser una data anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El camp :attribute ha d\'estar entre :min i :max.',
        'file'    => 'El camp :attribute ha d\'estar entre :min i :max kilobytes.',
        'string'  => 'El camp :attribute ha d\'estar entre :min i :max characters.',
        'array'   => 'El camp :attribute ha de tenir entre :min i :max elements.',
    ],
    'boolean'              => 'El camp :attribute ha de ser verdader o fals.',
    'confirmed'            => 'El camp :attribute i la seva confirmació no coincideixen.',
    'date'                 => 'El camp :attribute no és una data vàlida.',
    'date_format'          => 'El camp :attribute no concorda amb el format :format.',
    'different'            => 'Els camps :attribute i :other han de ser differents.',
    'digits'               => 'El camp :attribute ha de contenir :digits dígits.',
    'digits_between'       => 'El camp :attribute ha de contenir entre :min i :max dígits.',
    'dimensions'           => 'El camp :attribute conté mides incorrectes.',
    'distinct'             => 'El camp :attribute està duplicat.',
    'email'                => 'El camp :attribute ha de ser un e-mail vàlid.',
    'exists'               => 'El camp marcat :attribute no és vàlid.',
    'file'                 => 'El camp :attribute ha de ser un fitxer.',
    'filled'               => 'El camp :attribute és obligatori.',
    'image'                => 'El camp :attribute ha de ser una imatge.',
    'in'                   => 'El camp marcat :attribute no és vàlid.',
    'in_array'             => 'El camp :attribute no existeix dins de :other.',
    'integer'              => 'El camp :attribute ha de ser un número enter.',
    'ip'                   => 'El camp :attribute ha de ser una adreça IP vàlida.',
    'json'                 => 'El camp :attribute ha de ser una cadena JSON vàlida.',
    'max'                  => [
        'numeric' => 'El camp :attribute no pot ser més gran que :max.',
        'file'    => 'El camp :attribute no pot ser més gran que :max kilobytes.',
        'string'  => 'El camp :attribute no pot ser més gran que :max characters.',
        'array'   => 'El camp :attribute no pot tenir més de :max elements.',
    ],
    'mimes'                => 'El camp :attribute ha de ser un fitxer de tipus: :values.',
    'mimetypes'            => 'El camp :attribute ha de ser un fitxer de tipus: :values.',
    'min'                  => [
        'numeric' => 'El camp :attribute ha de ser com a mínim :min.',
        'file'    => 'El camp :attribute ha de ser de com a mínim :min kilobytes.',
        'string'  => 'El camp :attribute ha de ser de com a mínim :min caràcters.',
        'array'   => 'El camp :attribute ha de tenir com a mínim :min elements.',
    ],
    'not_in'               => 'El camp marcat :attribute no és vàlid.',
    'numeric'              => 'El camp :attribute ha de ser un número.',
    'present'              => 'El camp :attribute ha d\'existir.',
    'regex'                => 'El format del camp :attribute no és vàlid.',
    'required'             => 'El camp :attribute és obligatori.',
    'required_if'          => 'El camp :attribute és obligatori quan el camp :other és :value.',
    'required_unless'      => 'El camp :attribute és obligatori a no ser que :other èsta entre els valors :values.',
    'required_with'        => 'El camp :attribute és obligatori quan hi ha :values.',
    'required_with_all'    => 'El camp :attribute és obligatori quan hi ha :values.',
    'required_without'     => 'El camp :attribute és obligatori quan no hi ha :values.',
    'required_without_all' => 'El camp :attribute és obligatori quan no hi ha cap valor dels següents: :values.',
    'same'                 => 'El camp :attribute i el camp :other han de ser iguals.',
    'size'                 => [
        'numeric' => 'El camp :attribute ha de tenir el tamany: :size.',
        'file'    => 'El camp :attribute ha de ser de :size kilobytes.',
        'string'  => 'El camp :attribute ha de ser de :size characters.',
        'array'   => 'El camp :attribute ha de contenir :size elements.',
    ],
    'string'               => 'El camp :attribute ha de ser una cadena.',
    'timezone'             => 'El camp :attribute ha de ser una zona horària vàlida.',
    'unique'               => 'El camp :attribute ja està registrat i no es pot repetir.',
    'uploaded'             => 'El camp :attribute no s\'ha pogut afegir.',
    'url'                  => 'El camp :attribute no és una adreça web vàlida.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];

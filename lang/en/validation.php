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

    'accepted' => ' :attribute field must be accepted.',
    'accepted_if' => ' :attribute field must be accepted when :other is :value.',
    'active_url' => ' :attribute field must be a valid URL.',
    'after' => ' :attribute field must be a date after :date.',
    'after_or_equal' => ' :attribute field must be a date after or equal to :date.',
    'alpha' => ' :attribute field must only contain letters.',
    'alpha_dash' => ' :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => ' :attribute field must only contain letters and numbers.',
    'array' => ' :attribute field must be an array.',
    'ascii' => ' :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => ' :attribute field must be a date before :date.',
    'before_or_equal' => ' :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => ' :attribute field must have between :min and :max items.',
        'file' => ' :attribute field must be between :min and :max kilobytes.',
        'numeric' => ' :attribute field must be between :min and :max.',
        'string' => ' :attribute field must be between :min and :max characters.',
    ],
    'boolean' => ' :attribute field must be true or false.',
    'can' => ' :attribute field contains an unauthorized value.',
    'confirmed' => ' :attribute field confirmation does not match.',
    'contains' => ' :attribute field is missing a required value.',
    'current_password' => ' password is incorrect.',
    'date' => ' :attribute field must be a valid date.',
    'date_equals' => ' :attribute field must be a date equal to :date.',
    'date_format' => ' :attribute field must match the format :format.',
    'decimal' => ' :attribute field must have :decimal decimal places.',
    'declined' => ' :attribute field must be declined.',
    'declined_if' => ' :attribute field must be declined when :other is :value.',
    'different' => ' :attribute field and :other must be different.',
    'digits' => ' :attribute field must be :digits digits.',
    'digits_between' => ' :attribute field must be between :min and :max digits.',
    'dimensions' => ' :attribute field has invalid image dimensions.',
    'distinct' => ' :attribute field has a duplicate value.',
    'doesnt_end_with' => ' :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => ' :attribute field must not start with one of the following: :values.',
    'email' => ' :attribute field must be a valid email address.',
    'ends_with' => ' :attribute field must end with one of the following: :values.',
    'enum' => ' selected :attribute is invalid.',
    'exists' => ' selected :attribute is invalid.',
    'extensions' => ' :attribute field must have one of the following extensions: :values.',
    'file' => ' :attribute field must be a file.',
    'filled' => ' :attribute field must have a value.',
    'gt' => [
        'array' => ' :attribute field must have more than :value items.',
        'file' => ' :attribute field must be greater than :value kilobytes.',
        'numeric' => ' :attribute field must be greater than :value.',
        'string' => ' :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => ' :attribute field must have :value items or more.',
        'file' => ' :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => ' :attribute field must be greater than or equal to :value.',
        'string' => ' :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => ' :attribute field must be a valid hexadecimal color.',
    'image' => ' :attribute field must be an image.',
    'in' => ' selected :attribute is invalid.',
    'in_array' => ' :attribute field must exist in :other.',
    'integer' => ' :attribute field must be an integer.',
    'ip' => ' :attribute field must be a valid IP address.',
    'ipv4' => ' :attribute field must be a valid IPv4 address.',
    'ipv6' => ' :attribute field must be a valid IPv6 address.',
    'json' => ' :attribute field must be a valid JSON string.',
    'list' => ' :attribute field must be a list.',
    'lowercase' => ' :attribute field must be lowercase.',
    'lt' => [
        'array' => ' :attribute field must have less than :value items.',
        'file' => ' :attribute field must be less than :value kilobytes.',
        'numeric' => ' :attribute field must be less than :value.',
        'string' => ' :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => ' :attribute field must not have more than :value items.',
        'file' => ' :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => ' :attribute field must be less than or equal to :value.',
        'string' => ' :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => ' :attribute field must be a valid MAC address.',
    'max' => [
        'array' => ' :attribute field must not have more than :max items.',
        'file' => ' :attribute field must not be greater than :max kilobytes.',
        'numeric' => ' :attribute field must not be greater than :max.',
        'string' => ' :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => ' :attribute field must not have more than :max digits.',
    'mimes' => ' :attribute field must be a file of type: :values.',
    'mimetypes' => ' :attribute field must be a file of type: :values.',
    'min' => [
        'array' => ' :attribute field must have at least :min items.',
        'file' => ' :attribute field must be at least :min kilobytes.',
        'numeric' => ' :attribute field must be at least :min.',
        'string' => ' :attribute field must be at least :min characters.',
    ],
    'min_digits' => ' :attribute field must have at least :min digits.',
    'missing' => ' :attribute field must be missing.',
    'missing_if' => ' :attribute field must be missing when :other is :value.',
    'missing_unless' => ' :attribute field must be missing unless :other is :value.',
    'missing_with' => ' :attribute field must be missing when :values is present.',
    'missing_with_all' => ' :attribute field must be missing when :values are present.',
    'multiple_of' => ' :attribute field must be a multiple of :value.',
    'not_in' => ' selected :attribute is invalid.',
    'not_regex' => ' :attribute field format is invalid.',
    'numeric' => ' :attribute field must be a number.',
    'password' => [
        'letters' => ' :attribute field must contain at least one letter.',
        'mixed' => ' :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => ' :attribute field must contain at least one number.',
        'symbols' => ' :attribute field must contain at least one symbol.',
        'uncompromised' => ' given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => ' :attribute field must be present.',
    'present_if' => ' :attribute field must be present when :other is :value.',
    'present_unless' => ' :attribute field must be present unless :other is :value.',
    'present_with' => ' :attribute field must be present when :values is present.',
    'present_with_all' => ' :attribute field must be present when :values are present.',
    'prohibited' => ' :attribute field is prohibited.',
    'prohibited_if' => ' :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => ' :attribute field is prohibited unless :other is in :values.',
    'prohibits' => ' :attribute field prohibits :other from being present.',
    'regex' => ' :attribute field format is invalid.',
    'required' => ' :attribute field is required.',
    'required_array_keys' => ' :attribute field must contain entries for: :values.',
    'required_if' => ' :attribute field is required when :other is :value.',
    'required_if_accepted' => ' :attribute field is required when :other is accepted.',
    'required_if_declined' => ' :attribute field is required when :other is declined.',
    'required_unless' => ' :attribute field is required unless :other is in :values.',
    'required_with' => ' :attribute field is required when :values is present.',
    'required_with_all' => ' :attribute field is required when :values are present.',
    'required_without' => ' :attribute field is required when :values is not present.',
    'required_without_all' => ' :attribute field is required when none of :values are present.',
    'same' => ' :attribute field must match :other.',
    'size' => [
        'array' => ' :attribute field must contain :size items.',
        'file' => ' :attribute field must be :size kilobytes.',
        'numeric' => ' :attribute field must be :size.',
        'string' => ' :attribute field must be :size characters.',
    ],
    'starts_with' => ' :attribute field must start with one of the following: :values.',
    'string' => ' :attribute field must be a string.',
    'timezone' => ' :attribute field must be a valid timezone.',
    'unique' => ' :attribute has already been taken.',
    'uploaded' => ' :attribute failed to upload.',
    'uppercase' => ' :attribute field must be uppercase.',
    'url' => ' :attribute field must be a valid URL.',
    'ulid' => ' :attribute field must be a valid ULID.',
    'uuid' => ' :attribute field must be a valid UUID.',

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

    'attributes' => [
        'role.en'=>'Role Name With English',
        'role.ar'=>'Role Name With Arbic',
        'name.en'=>'Name With English',
        'name.ar'=>'Name With Arbic',
        'permessions'=>'permessions',


    ],

];
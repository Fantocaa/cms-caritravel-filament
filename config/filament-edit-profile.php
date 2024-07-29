<?php

return [
    'show_custom_fields' => true,
    'custom_fields' => [
        'phone' => [
            'type' => 'text',
            'label' => 'Phone Number',
            'placeholder' => 'Enter your phone number',
            'required' => false,
            'rules' => 'nullable|numeric',
        ],
    ]
];

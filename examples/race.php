<?php

// Dati paraugu darbināšanai

return (object) [
	'id' => 123,
	'results' => [
		(object) [
			'id' => 4324,
			'place' => 1,
			'participation' => (object) [
				'number' => 212,
				'person' => (object) [
					'id' => 13425,
					'first_name' => 'Pēteris',
					'last_name' => 'Piemērs',
					'gender' => 'm',
					'country' => (object) [
						'alpha3' => 'LVA',
					],
					'date_of_birth' => '1999-01-01',
				],
			],
			'performance' => 969.98,
		],
		(object) [
			'id' => 4324,
			'place' => 2,
			'participation' => (object) [
				'number' => null,
				'person' => (object) [
					'id' => 13425,
					'first_name' => 'Patrīcija',
					'last_name' => 'Parauga',
					'gender' => 'f',
					'country' => null,
					'date_of_birth' => null,
				],
			],
			'performance' => 982.18,
		],
	],
];
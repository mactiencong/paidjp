<?php
// $data = array(
// 		'body'=>array(
// 				'memberData'=>array(
// 						'b2bMemberId'=>'1234',
// 						'zipCode'=>'14566'
// 				)
// 		),
// 		'header'=>array(
// 				'apiAuthCode'=>'eec6b5739dd9aecfff7bd5cf8fac5b2c'
// 		)
// );
// $data = array(
// 		'body'=>array(
// 				'b2bMemberIds'=>array(
// 						'maticotest',
// 						'123456'
// 				)
// 		),
// 		'header'=>array(
// 				'apiAuthCode'=>'eec6b5739dd9aecfff7bd5cf8fac5b2c'
// 		)
// );
$data = array(
		'body'=>array(
				'credits'=>array(
						'credit'=>array(
								array(
										'b2bMemberId'=>'1234',
										'b2bCreditId'=>'14567'
								)
						)
				)
		),
		'header'=>array(
				'apiAuthCode'=>'eec6b5739dd9aecfff7bd5cf8fac5b2c'
		)
);
echo json_encode($data);
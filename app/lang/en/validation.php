<?php

return array(

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

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => "The :attribute must be a date after :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => "The :attribute must be a date before :date.",
	"between"              => array(
		"numeric" => "The :attribute must be between :min and :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",
		"string"  => "The :attribute must be between :min and :max characters.",
		"array"   => "The :attribute must have between :min and :max items.",
	),
	"confirmed"            => "Veuillez confirmer le champ :attribute.",
	"date"                 => "Le champ :attribute n'est pas une date valide.",
	"date_format"          => "Le champ :attribute n'est pas une date valide.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "The :attribute must be a valid email address.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "Le champ :attribute doit être un entier.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => "Le champ :attribute ne peut pas être supérieur à :max.",
		"file"    => "La taille maximale de la :attribute ne peut pas dépasser :max kilobytes.",
		"string"  => "Le champ :attribute ne peut pas avoir une longueur supérieure à  :max caractères.",
		"array"   => "The :attribute may not have more than :max items.",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "Le champ :attribute ne peut être inférieur à :min.",
		"file"    => "La :attribute doit avoir une taille minimale de :min kilobytes.",
		"string"  => "Le champ :attribute ne peut pas avoir une longueur inférieure à :min caractères.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "Le champ :attribute ne doit contenir que des chiffres.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "Le champ :attribute doit être renseigné.",
	"required_if"          => "The :attribute field is required when :other is :value.",
    "required_with"        => "Le champ :values ne peut exister sans le champ :attribute.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",

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

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

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

	'attributes' => array(
        'nom' => 'Nom',
        'prenom' => 'prénom',
        'mdp' => 'Mot de passe',
        'mdp_confirmation' => 'Mot de passe',
        'email' => 'E-mail',
        'identifant' => 'Identifiant',
        'type' => 'Type',
        'tel' => 'Numero de téléphone',
        'ref' => 'Référence',
        'stock' => 'Quantité en stock',
        'seuil_alert_stock' => 'Seuil alerte de stock',
        'quantite' => 'quantité',
        'userfile' => 'photo',
        'country_id' => 'pays',
        'city_naissance_id' => 'Ville de naissance',
        'autre_ville_naissance' => 'autre Ville de naissance',
        'city_id' => 'ville adresse',
        'nom_pere' => 'nom du père',
        'prenom_pere' => 'prénom du père',
        'nom_mere' => 'nom de la mère',
        'prenom_mere' => 'prénom de la mère',
    ),

);

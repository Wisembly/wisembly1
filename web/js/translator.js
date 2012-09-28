var Translator = function (lang) {

	this.lang = lang;

	this.translations = {
		"corporate_default_price" : {
			"fr" : "À partir de 20€ <sup>HT</sup>",
			"en" : "From 20€ <sup>Excl. VAT</sup>"
		},
		"corporate_start_btn" : {
			"fr" : "Créez votre Wiz !",
			"en" : "Start your Wiz now !"
		},
		"attendees_is_nan" : {
			"fr" : "On n'accepte que des nombres ;)",
			"en" : "Attendees must be numeric"
		},
		"attendees_limit_exceeded" : {
			"fr" : "400 utilisateurs maximum",
			"en" : "No more than 400 users allowed"
		}
	}

	this.get = function (key) {
        try { 
            return(this.translations[key][this.lang]);
        }
        catch (error) {
            console.error("[Translator] WHOOPS ! " + error.message + " for Key \"" + key + "\"");
            return key;
        }
	}

}
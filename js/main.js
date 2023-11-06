import { SendMail } from "./components/mailer.js";

(() => {
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                message: "Hello Vue!",
            };
        },

        methods: {
            processMailFailure(result) {
                // Show the error message
                let errorPopup = document.querySelector(".error-message");
                errorPopup.classList.add("show");

                // Hide the success message
                let successPopup = document.querySelector(".success-message");
                successPopup.classList.remove("show");

                // Mark any empty fields/inputs with an error class
                // Show some errors in the UI here to let the user know the mail attempt was not successful
            },

            processMailSuccess(result) {
                // Show the success message
                let successPopup = document.querySelector(".success-message");
                successPopup.classList.add("show");

                // Hide the error message
                let errorPopup = document.querySelector(".error-message");
                errorPopup.classList.remove("show");

                // Show some UI elements here to let the user know the mail attempt was successful.
            },

            processMail(event) {
				// use the SendMail component to process mail
				SendMail(this.$el.parentNode)
					.then((data) => this.processMailSuccess(data))
					.catch((err) => this.processMailFailure(err));
			},
        },
    }).mount("#mail-form");
})();

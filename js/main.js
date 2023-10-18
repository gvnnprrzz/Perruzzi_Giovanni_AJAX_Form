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
				// show a failure message in the UI
				let errorPopup = document.querySelector(".error");
				errorPopup.classList.add("show");

				let successPopup = document.querySelector(".success");
				successPopup.classList.remove("show");

				// use this.$refs to connect to the elements on the page
				// mark any empty fields/inputs with an error class
				// show some errors in the UI here to let the user know the mail attempt was not successful
			},


			processMailSuccess(result) {
				// show a success message in the UI
				let successPopup = document.querySelector(".success");
				successPopup.classList.add("show");

				let mainButton = document.querySelector(".wrapper.display");
				mainButton.classList.remove("show");

				let errorPopup = document.querySelector(".error");
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

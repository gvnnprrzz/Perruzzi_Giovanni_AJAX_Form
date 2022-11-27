import { SendMail } from "./components/mailer.js";

(() => {
    const { createApp } = Vue

    createApp({
        data() {
            return {
                message: 'Hello Vue!'
            }
        },

        methods: {
            processMailFailure(result) {
                // show a failure message in the UI
                let popup = document.querySelector('.error');
                popup.classList.add("show");
                let popup2 = document.querySelector('.success');
                popup2.classList.remove("show");
                // use this.$refs to connect to the elements on the page and mark any empty fields/inputs with an error class
                // show some errors in the UI here to let the user know the mail attempt was successful
            },

            processMailSuccess(result) {
                // show a success message in the UI
                 let popup2 = document.querySelector('.success');
                popup2.classList.add("show");
                let mainButton = document.querySelector('.wrapper.display');
                mainButton.classList.remove("show");
                let popup = document.querySelector('.error');
                popup.classList.remove("show");
                // show some UI here to let the user know the mail attempt was successful
            },

            processMail(event) {
                // use the SendMail component to process mail
                SendMail(this.$el.parentNode)
                    .then(data => this.processMailSuccess(data))
                    .catch(err => this.processMailFailure(err));
            }
        }
    }).mount('#mail-form')
})();
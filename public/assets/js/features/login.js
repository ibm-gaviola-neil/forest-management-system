import { submitForm } from "../services/formService.js";
import { loader } from "../ui/html-ui.js";

const loginForm = document.getElementById('loginForm');

loginForm.addEventListener('submit', async (e) =>{
    e.preventDefault();
    const loginBtn = document.getElementById('login-btn');
    const loading = loader(' Logging in...');
    const formData = new FormData(e.target);
    loginBtn.innerHTML = `${loading}`;

    try {
        const response = await submitForm({
            url: '/login',
            formData,
            buttonId: 'login-btn',
            errorDisplayId: 'loginResponse', 
        })
        loginBtn.innerHTML = `Log In`;
        window.location.replace(response.redirect)
    } catch (error) {
        console.log(error)
        loginBtn.innerHTML = `Log In`;
    }
});
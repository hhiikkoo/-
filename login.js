document.getElementById('loginForm').addEventListener('submit', function(event) {
    let username = document.getElementById('label_username').value;
    let password = document.getElementById('label_password').value;

    if (!username || !password) {
        event.preventDefault(); // Prevent form submission if fields are empty
        alert("Пожалуйста, заполните все поля!");
    }
});

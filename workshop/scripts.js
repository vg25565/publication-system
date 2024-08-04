document.getElementById('signupForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    const response = await fetch('signup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    });

    const result = await response.json();
    const messageElement = document.getElementById('message');
    if (result.success) {
        messageElement.style.color = 'green';
        messageElement.textContent = 'Signup successful!';
    } else {
        messageElement.style.color = 'red';
        messageElement.textContent = 'Signup failed: ' + result.message;
    }
});
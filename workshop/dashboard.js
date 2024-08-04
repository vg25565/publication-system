document.addEventListener('DOMContentLoaded', async function() {
    const token = localStorage.getItem('token');
    
    if (!token) {
        window.location.href = 'signup.html';
        return;
    }
    
    const response = await fetch('verify_token.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    });

    const result = await response.json();
    
    if (!result.success) {
        localStorage.removeItem('token');
        window.location.href = 'signup.html';
    } else {
        document.getElementById('message').textContent = 'Token is valid';
    }
});

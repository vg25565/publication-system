async function fetchPapers() {
    const token = localStorage.getItem('token');

    const response = await fetch('papers.php', {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        }
    });

    const result = await response.json();
    if (result.success) {
        displayPapers(result.papers);
    } else {
        console.error(result.message);
    }
}

function displayPapers(papers) {
    const papersContainer = document.getElementById('papersContainer');
    papersContainer.innerHTML = '';

    papers.forEach(paper => {
        const paperElement = document.createElement('div');
        paperElement.className = 'paper';
        paperElement.innerHTML = `
            <h3>${paper.title}</h3>
            <p>${paper.abstract}</p>
            <small>State: ${paper.state}</small>
            <small>Created at: ${paper.created_at}</small>
        `;
        papersContainer.appendChild(paperElement);
    });
}

// Call the fetchPapers function when the page loads
document.addEventListener('DOMContentLoaded', fetchPapers);

function togglePWDIDSection() {
    const isPWD = document.getElementById('ifpwd').value;
    const pwdIDSection = document.getElementById('pwd_id_section');
    pwdIDSection.style.display = (isPWD === 'Yes') ? 'block' : 'none';
}

function toggleVoterFields() {
    const voterStatus = document.getElementById('voter_status').value;
    const votersPrecinctNoField = document.getElementById('voters_precinct_no_field');
    const votersIDField = document.getElementById('voters_id_field');
    
    if (voterStatus === 'Yes') {
        votersPrecinctNoField.style.display = 'block';
        votersIDField.style.display = 'block';  
    } else {
        votersPrecinctNoField.style.display = 'none';
        votersIDField.style.display = 'none';
    }
}

window.onload = function() {
    togglePWDIDSection(); //based on the value of "PWD (Y/N)"
    toggleVoterFields(); //based on the value of "Voter Status"
};
const keycloak = new Keycloak({
    url: 'http://localhost:8082/',
    realm: 'sae-services',
    clientId: 'php-service'
})

async function initKeyCloak(){
    return await keycloak.init(initOptions);
}

async function fetchConnectedUser() {

    console.log(keycloak);
    console.log("Subject : " + keycloak.token);
    const response = await fetch(`http://localhost:8082/api/users` , {
        mode: 'no-cors',
        headers: {
            'Authorization': `Bearer ${keycloak.token}`,
            'Content-Type': 'application/json'
        }
    });
    
    console.log(response);
    console.log(response.json());
    return response.json();
}

const initOptions = {
    onLoad: 'login-required',
};

function logout(){
    location.replace("index.php");
    Cookies.remove('token');
    Cookies.remove('callback');
    keycloak.logout();
}

document.getElementById('logoutButton').addEventListener('click', function() {
    logout();
});
document.getElementById('profileButton').addEventListener('click', function() {
    let username = keycloak.idTokenParsed.preferred_username;
    location.replace("index.php?controller=Default&action=listUser&user="+username);
});

let authenticated = false;

try{
    initKeyCloak().then(function(authenticated = false){
        console.log("Authentification Successfull ! ");
        console.log(keycloak.idTokenParsed.preferred_username);

        // let user = fetchConnectedUser();
    }).catch(function(error){
        console.log("Error " + error);
    });
}
catch (error) {
    console.log('Error : ' + error);
};

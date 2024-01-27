const keycloak = new Keycloak({
    url: 'http://localhost:8082/',
    realm: 'sae-services',
    clientId: 'php-service'
})

async function initKeyCloak(){
    return await keycloak.init(initOptions);
}
const initOptions = {
    onLoad: 'login-required',
};
function logout(){
    Cookies.remove('token');
    Cookies.remove('callback');
    keycloak.logout();
}

document.getElementById('logoutButton').addEventListener('click', function() {
    logout();
});

let authenticated = false;

try{
    initKeyCloak().then(function(authenticated = false){
        Cookies.set('token', keycloak.token);
    
    }).catch(function(error){
        console.log("Error " + error)
    });
}
catch (error) {
    console.log('Error : ' + error);
};

console.log(keycloak);

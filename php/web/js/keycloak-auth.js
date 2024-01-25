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
    
    window.location.href = 'http://localhost:8082/auth/realms/sae-services/protocol/openid-connect/logout?redirect_uri=https://localhost:8443/*';
  });

let authenticated = false;

try{
    initKeyCloak().then(function(authenticated = false){
        console.log("Keycloak token : " + JSON.stringify(keycloak));
        console.log('Init Response : ' + (authenticated ? 'Authenticated' : 'Not Authenticated'));
        console.log(authenticated);
        Cookies.set('token', keycloak.token);
        
        console.log("Test : " + JSON.stringify(keycloak.token) + "Authenticated ? " + keycloak.authenticated);
    
    }).catch(function(error){
        console.log("Error " + error)
    });

}
catch (error) {
    console.log('Error : ' + error);
};





    
    

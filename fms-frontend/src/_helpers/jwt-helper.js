import decode from "jwt-decode";
let JWTHelper = {
    getToken: function () {
        // Retrieves the user token from localStorage
        return localStorage.getItem("token");
    },

    isTokenExpired: function (token) {
        try {
            const decoded = decode(token);
            // console.log(decoded);
            
            if (decoded.exp < Date.now() / 1000) {
                // Checking if token is expired.
                return true;
            } else return false;
        } catch (err) {
            console.log("expired check failed! Line 42: AuthService.js");
            return false;
        }
    },
    decodeToken:function (token) {
        return decode(token);
    }
}
export default JWTHelper;
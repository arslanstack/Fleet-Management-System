import { adminConstants } from "../_constants/admin.constants";
import { adminService } from "../_services/admin.service";
import { alertActions } from ".";
import { apiService } from "../_services/api.service";
// import { history } from "../_helpers";

export const adminActions = {
  login: function (email, password, history) {
   
    return dispatch => {
     
      dispatch(alertActions.clear());
      dispatch(request({ email }));

      adminService.login(email, password).then(
        token => {
          dispatch(success(token));
          history.push("/dashboard");
        },
        error => {
          dispatch(failure(error));


          dispatch(alertActions.error(error == "TypeError: Failed to fetch" ? "Internet Problem" : error));
        }
      );
    };
    function request(email) {
      return { type: adminConstants.LOGIN_REQUEST, email };
    }
    function success(token) {
      return { type: adminConstants.LOGIN_SUCCESS, token };
    }
    function failure(error) {
      return { type: adminConstants.LOGIN_FAILURE, error };
    }
  },

  getCurrentAdmin: function (history) {
    return dispatch => {
      dispatch(request());

      adminService.getCurrentAdmin().then(
        user => {
          dispatch(success(user));

          // history.push('/');
        },
        error => {
          dispatch(failure(error));
        
          // console.log(error);
          // dispatch(alertActions.error(error));
        }
      );
    };

    function request() {
      return { type: adminConstants.GET_CURRENT_REQUEST };
    }
    function success(admin, infosetting) {
      return { type: adminConstants.GET_CURRENT_SUCCESS, admin, infosetting };
    }
    function failure(error) {
      return { type: adminConstants.GET_CURRENT_FAILURE, error };
    }
  },

  logout: function () {
    adminService.logout();
    return { type: adminConstants.LOGOUT };
  },

  getAll: function () {
    return dispatch => {
      dispatch(request());

      adminService.getAll().then(
        users => dispatch(success(users)),
        error => dispatch(failure(error))
      );
    };

    function request() {
      return { type: adminConstants.GETALL_REQUEST };
    }
    function success(users) {
      return { type: adminConstants.GETALL_SUCCESS, users };
    }
    function failure(error) {
      return { type: adminConstants.GETALL_FAILURE, error };
    }
  }
};

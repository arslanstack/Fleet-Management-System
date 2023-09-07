import { adminConstants } from '../_constants/admin.constants';

let token = JSON.parse(localStorage.getItem('token'));
const initialState = token ? { loggedIn: true, token, admin: null, infosetting: null } : {};

export function authentication(state = initialState, action) {
  switch (action.type) {
    case adminConstants.LOGIN_REQUEST:
      return {
        loggingIn: true,
        token: action.token
      };
    case adminConstants.LOGIN_SUCCESS:
      return {
        loggedIn: true,
        token: action.token
      };
    case adminConstants.LOGIN_FAILURE:
      return {};

    case adminConstants.GET_CURRENT_SUCCESS:
      return {
        loggedIn: true,
        token: state.token,
        admin: action.admin
      };
    case adminConstants.GET_CURRENT_FAILURE:
      localStorage.removeItem('token');
      return {};

    case adminConstants.LOGOUT:
      return {};

    default:
      return state
  }
}
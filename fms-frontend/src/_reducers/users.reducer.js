
import { userConstants } from '../_constants/user.constants';

export function users(state = {}, action) {
  switch (action.type) {
    case userConstants.GETALL_REQUEST:
      return {
        loading: true
      };
    case userConstants.GETALL_SUCCESS:
      return {
        list: action.users
      };
    case userConstants.GETALL_FAILURE:
      return {
        error: action.error
      };

    case userConstants.GETSINGLE_REQUEST:
      return {
        loading: true
      };
    case userConstants.GETSINGLE_SUCCESS:
      return {
        single: action.user
      };
    case userConstants.GETSINGLE_FAILURE:
      return {
        error: action.error
      };



    case userConstants.SET_STATUS_SUCCESS:
      let single = state.single;
      single.status = action.status;
      return {
        single: single
      };
    case userConstants.SET_STATUS_FAILURE:
      return {
        error: action.error
      };
    default:
      return state
  }
}

import { adminConstants } from '../_constants/admin.constants';

export function admins(state = {}, action) {
  switch (action.type) {
    case adminConstants.GETALL_REQUEST:
      return {
        loading: true
      };
    case adminConstants.GETALL_SUCCESS:
      return {
        items: action.users
      };
    case adminConstants.GETALL_FAILURE:
      return {
        error: action.error
      };
    default:
      return state
  }
}
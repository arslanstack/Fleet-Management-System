
import { userCustomNotificationConstants } from '../_constants/userCustomNotification.constants';

export function userCustomNotifications(state = {}, action) {
  switch (action.type) {
    case userCustomNotificationConstants.GETALL_REQUEST:
      return {
        loading: true
      };
    case userCustomNotificationConstants.GETALL_SUCCESS:
      return {
        list: action.userCustomNotifications
      };
    case userCustomNotificationConstants.GETALL_FAILURE:
      return {
        error: action.error
      };

    case userCustomNotificationConstants.GETSINGLE_REQUEST:
      return {
        loading: true
      };
    case userCustomNotificationConstants.GETSINGLE_SUCCESS:
      return {
        single: action.userCustomNotificationObj
      };
    case userCustomNotificationConstants.GETSINGLE_FAILURE:
      return {
        error: action.error
      };

    case userCustomNotificationConstants.ADD_SUCCESS:
      return {
        single: action.userCustomNotificationObj
      };
    case userCustomNotificationConstants.ADD_FAILURE:
      return {
        error: action.error
      };

    case userCustomNotificationConstants.UPDATE_SUCCESS:
      return {
        single: action.userCustomNotificationObj
      };
    case userCustomNotificationConstants.UPDATE_FAILURE:
      return {
        error: action.error
      };

    case userCustomNotificationConstants.DELETE_SUCCESS:
      return {
        single: action.userCustomNotificationObj
      };
    case userCustomNotificationConstants.DELETE_FAILURE:
      return {
        error: action.error
      };


    default:
      return state
  }
}
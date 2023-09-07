import { combineReducers } from 'redux';

import { authentication } from './authentication.reducer';
import { admins } from './admins.reducer';
import { users } from './users.reducer';
import { userCustomNotifications } from './userCustomNotification.reducer';
import { alert } from './alert.reducer';

const rootReducer = combineReducers({
  authentication,
  admins,
  users,
  userCustomNotifications,
  alert
});

export default rootReducer;
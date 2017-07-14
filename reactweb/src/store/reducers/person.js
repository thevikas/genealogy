import {
    SET_USER_PROFILE,
    ADD_PEOPLE,
    ADD_PEOPLE_SUCCESS
} from 'constants/ActionTypes';


export default function person(state = {}, action) {
    switch (action.type) {
        case SET_USER_PROFILE:
            var clone = Object.assign({}, state, action.user);
            return clone;
        case ADD_PEOPLE:
            var clone = Object.assign({}, state, action.people);
            return clone;
        default:
            return state;
    }
}

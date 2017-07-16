import {
    SET_USER_PROFILE,
    ADD_PEOPLE,
    SET_PERSON,
    ADD_PERSON_SUCCESS
} from 'constants/ActionTypes';


export default function person(state = {}, action) {
    switch (action.type) {
        case SET_USER_PROFILE:
            var clone = Object.assign({}, state, action.user);
            return clone;
        case SET_PERSON:
            console.log("found in reducer setperson",action);
            //var clone = Object.assign({}, state, action.personp);
            return action.personp;
        case ADD_PERSON_SUCCESS:
            console.log("got back from API",action);
            var clone = Object.assign({}, state, action.payload.data);
            return clone;
        default:
            return state;
    }
}

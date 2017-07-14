import {
    SET_USER_PROFILE,
    ADD_PEOPLE,
    ADD_PEOPLE_SUCCESS
} from 'constants/ActionTypes';

export default function person(state = [], action) {
    switch (action.type) {
        case ADD_PEOPLE_SUCCESS:
            return action.payload.data;
        default:
            return state;
    }
}

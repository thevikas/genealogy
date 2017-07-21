import {
    FIND_PERSON,
    FIND_UPDATE
} from 'ActionTypes';

export default function updates(state = {}, action) {
    switch (action.type) {
        case FIND_PERSON:
            var clone = Object.assign({}, state, {
                id_person: action.id_person
            });
            return clone;
        default:
            return state;
    }
}

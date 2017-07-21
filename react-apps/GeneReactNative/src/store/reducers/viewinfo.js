import * as types from 'constants/ActionTypes';

export default function setviewinfo(state = {}, action) {
    switch (action.type) {
        case types.SET_VIEWINFO:
            var clone = Object.assign({}, state, {
                name: action.viewinfo.name,
                path: action.viewinfo.path
            });
            return clone;
        default:
            return state;
    }
}

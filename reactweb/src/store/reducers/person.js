import {
    SET_USER_PROFILE,
    ADD_PEOPLE,
    SET_PERSON,
    ADD_PERSON_SUCCESS,
    APPEND_TO_CHILDREN
} from 'constants/ActionTypes';
import  * as Helpers from '../helperfunctions.js'


export default function person(state = {}, action) {
    switch (action.type) {
        case SET_USER_PROFILE:
            var clone = Object.assign({}, state, action.user);
            return clone;
        case SET_PERSON:
            console.log("found in reducer setperson",action);
            //var clone = Object.assign({}, state, action.personp);
            return action.personp;
        case APPEND_TO_CHILDREN:
        {
            var children_array;
            if(state.children == undefined)
            {
                children_array = [{person:{},father:{},mother:{},spouse:{}}];
                Helpers.copyPersonObject(children_array[0].person,action.payload.data.person);
                Helpers.copyPersonObject(children_array[0].father,action.payload.data.father);
                Helpers.copyPersonObject(children_array[0].mother,action.payload.data.mother);

                if(action.payload.data.child_ids && action.payload.data.child_ids.length>0)
                {
                    children_array[0].child_ids = [];
                    for(var i=0;i<action.payload.data.child_ids.length; i++)
                        children_array[0].child_ids.push(action.payload.data.child_ids[i]);
                }

            }
            else
                children_array  = state.children.concat(action.payload.data);

            var clone = Object.assign({}, state, {children: children_array});
            return clone;
        }
        case ADD_PERSON_SUCCESS:
            console.log("got back from API",action);
            var clone = Object.assign({}, state, action.payload.data);
            return clone;
        default:
            return state;
    }
}

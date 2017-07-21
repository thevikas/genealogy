import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import moment from 'moment';
import Gravatar from 'react-gravatar'

import PropTypes from 'prop-types';

export class MessageItem extends Component {
    render() {
        return (
            <li>
              <Link to={'/update/view/' + this.props.message.id_update}>
                <span className="image"><Gravatar size={29} className="avatar" alt="Avatar" email={this.props.filedBy.email} /></span>
                <span>
                  <span>{this.props.filedBy.name}</span>
                  <span className="time">{moment(this.props.message.createdAt).fromNow()}</span>
                </span>
                <span className="message">
                  {this.props.message.des}
                </span>
              </Link>
            </li>
        )
    }
}

MessageItem.propTypes = {
  message: PropTypes.object.isRequired,
  filedBy: PropTypes.object.isRequired
};

export default MessageItem;

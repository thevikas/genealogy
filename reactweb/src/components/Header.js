import React, {Component} from 'react';
import {Link} from 'react-router-dom';
import moment from 'moment';

import PropTypes from 'prop-types';

export class Breadcrumb extends Component {
    render() {
        return (
            <div id="content-header">
              <div id="breadcrumb"> <a href="index.html" title="Go to Home" className="tip-bottom"><i className="icon-home"></i> Home</a></div>
            </div>
        )
    }
}

export default Breadcrumb;

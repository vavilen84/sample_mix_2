import React from "react";
import Holder from "../holder/Holder";
import "./style.scss";
import LinkedinIcon from '../../../static/img/icons/linkedin.svg'
import GithubIcon from '../../../static/img/github.png'

function Footer() {
    return (
        <div className={'footer'}>
            <Holder>
                <div className={'clear'}/>
            </Holder>
        </div>
    );
}

export default Footer;

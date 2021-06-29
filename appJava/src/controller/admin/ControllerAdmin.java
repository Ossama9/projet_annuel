package controller.admin;

import controller.ControllerOne;
import persistence.User;

public class ControllerAdmin extends ControllerOne {

    User admin;

    public void initData(User admin){
        if( admin != null )
            this.admin = admin;
        else
            goToLandingPage();
    }
}

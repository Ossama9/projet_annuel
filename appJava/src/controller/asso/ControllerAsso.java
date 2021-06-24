package controller.asso;

import controller.ControllerOne;
import persistence.Asso;

public class ControllerAsso extends ControllerOne {

    public Asso asso;

    public void initData(Asso asso){
        if( asso != null )
            this.asso = asso;

        else
            goToLandingPage();
    }
}

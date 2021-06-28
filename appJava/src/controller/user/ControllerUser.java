package controller.user;


import controller.ControllerOne;
import javafx.fxml.FXML;
import javafx.scene.text.Text;
import persistence.User;

public class ControllerUser extends ControllerOne {

    public User user;

    @FXML private Text availableCoinsField;
    @FXML private Text usedCoins;


    public void initData(User user){
        if(user != null) {
            this.user = user;
            availableCoinsField.setText(String.valueOf(user.getAvailableCoins()));
            usedCoins.setText(String.valueOf(user.getUsedCoins()));
        }
        else
            goToLandingPage();
    }


}

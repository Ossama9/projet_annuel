package controller.project;

import controller.ControllerOne;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.control.*;
import javafx.scene.layout.Pane;
import javafx.scene.layout.VBox;
import javafx.scene.text.Text;
import javafx.scene.text.TextAlignment;
import javafx.stage.Popup;
import manager.CoinsManager;
import manager.ProjectManager;
import persistence.Asso;
import persistence.Project;
import persistence.User;

import java.sql.SQLException;
import java.time.LocalDate;

public class ProjectIndexController extends ControllerOne {

    @FXML private Text earnedCoins;
    @FXML private Text givenCoins;
    @FXML private Pane givenText;
    @FXML private Pane connection;

    @FXML private Button giveUpBtn;
    @FXML private Button supprBtn;
    @FXML private Button deconexion;

    @FXML private Text title;
    @FXML private Text successMsg;
    @FXML private Text depositDate;
    @FXML private Text associationName;
    @FXML private Text startDate;
    @FXML private Text endDate;
    @FXML private Text description;

    @FXML private Button modifyStartDate;
    @FXML private Button modifyEndDate;
    @FXML private Button modifyDescription;

    @FXML private Button payBtn;

    public Project project;
    public User user;
    public Asso asso;

    public void initData(Project project){
        if( project == null )
            goToLandingPage();

        giveUpBtn.setVisible(false);
        connection.setVisible(true);
        payBtn.setVisible(false);
        deconexion.setVisible(false);
        givenText.setVisible(false);

        modifyStartDate.setVisible(false);
        modifyEndDate.setVisible(false);
        modifyDescription.setVisible(false);

        if( asso != null ){
            supprBtn.setVisible(true);
            //this.asso = asso;
        }

        this.project = project;


        earnedCoins.setText(String.valueOf(project.getCoinsEarned()));

        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());
    }

    public void initData(Project project, User user){
        if( project == null )
            goToLandingPage();

        if( user != null )
            this.user = user;
        else
            connection.setVisible(true);

        modifyStartDate.setVisible(false);
        modifyEndDate.setVisible(false);
        modifyDescription.setVisible(false);

        this.project = project;

        CoinsManager cm = new CoinsManager();
        earnedCoins.setText(String.valueOf(project.getCoinsEarned()));
        try {
            assert user != null;
            givenCoins.setText(String.valueOf(cm.getGivenCoins(project.getId(), user.getId())));
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }


        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());
    }

    public void initData(Project project, Asso asso){
        if( project == null )
            goToLandingPage();

        this.project = project;

        if( asso != null )
            this.asso = asso;

        giveUpBtn.setVisible(false);
        payBtn.setVisible(false);
        deconexion.setVisible(false);
        givenText.setVisible(false);



        earnedCoins.setText(String.valueOf(project.getCoinsEarned()));

        title.setText(project.getName());
        title.setTextAlignment(TextAlignment.CENTER);

        depositDate.setText(project.getDepositDate().toLocalDate().toString());
        associationName.setText(project.getAssoName());
        startDate.setText(project.getStartDate().toLocalDate().toString());
        endDate.setText(project.getEndDate().toLocalDate().toString());
        description.setText(project.getDescription());
    }


    @FXML
    public void createPopup(ActionEvent event){

        Popup popup = new Popup();

        Label label = new Label("Choisissez le montant de votre dont");
        label.setTextAlignment(TextAlignment.CENTER);
        label.setLayoutY(10);
        Slider slider = new Slider(0, user.getAvailableCoins(), (double)user.getAvailableCoins()/2);
        slider.setShowTickLabels(true);
        slider.setLayoutY(50);

        Button validate = new Button("Valider");
        validate.setStyle("-fx-background-color: #08f008");
        validate.setAlignment(Pos.BOTTOM_LEFT);

        EventHandler<ActionEvent> eventValidate = e -> donate((int)slider.getValue());

        validate.setOnAction(eventValidate);

        Button cancel = new Button("Annuler");
        cancel.setStyle("-fx-background-color: #ff0000");
        cancel.setAlignment(Pos.BOTTOM_RIGHT);

        EventHandler<ActionEvent> eventCancel = e -> popup.hide();

        cancel.setOnAction(eventCancel);

        VBox root = new VBox();
        root.setPadding(new Insets(20));
        root.setSpacing(10);
        root.setStyle("-fx-background-color: #ffffff");
        root.setAlignment(Pos.CENTER);
        root.getChildren().addAll(label, slider, validate, cancel);

        popup.getContent().add(root);
        popup.show(mainPane.getScene().getWindow());

    }

    public void donate(int amount){
        CoinsManager coinsManager = new CoinsManager();
        try {
            if (coinsManager.allreadyDonate(user.getId(), project.getId()) != 0) {
                coinsManager.updateDonation(user.getId(), project.getId(), amount);
            }
            else {
                coinsManager.createDonation(user.getId(), project.getId(), amount);
                successMsg.setText("Votre dons à bien été pris en compte !");
                successMsg.setTextAlignment(TextAlignment.CENTER);
                int tmp = Integer.parseInt(earnedCoins.getText())+amount;
                earnedCoins.setText(String.valueOf(tmp));
            }
        } catch (SQLException throwables) {
            throwables.printStackTrace();
        }
    }


    @FXML
    public void goBack(ActionEvent event){
        if (user != null)
            ControllerOne.loadUserIndex(event, user);
        else if (asso != null)
            ControllerOne.loadAssoIndex(event, asso);
        else
            goToLandingPage();
    }

    @FXML
    private void giveUp(ActionEvent event){
        CoinsManager coinManager = new CoinsManager();
        try{
            if( coinManager.supprDonnation(user.getId(), project.getId()) != 0 ) {
                successMsg.setText("Vous avez retiré votre soutient à ce projet ...");
                successMsg.setTextAlignment(TextAlignment.CENTER);
                givenCoins.setText("0");
            }
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }


    @FXML
    private void startDatePopup(ActionEvent event){
        Popup popup = new Popup();

        Label label = new Label("Choisissez la nouvelle date");
        label.setTextAlignment(TextAlignment.CENTER);
        label.setLayoutY(10);

        DatePicker datePicker = new DatePicker();
        datePicker.setValue(project.getStartDate().toLocalDate());

        Button validate = new Button("Valider");
        validate.setStyle("-fx-background-color: #08f008");
        validate.setAlignment(Pos.BOTTOM_LEFT);

        EventHandler<ActionEvent> eventValidate = e -> {
            modifyStartDate(datePicker.getValue());
            popup.hide();
            startDate.setText(datePicker.getValue().toString());
        };

        validate.setOnAction(eventValidate);

        Button cancel = new Button("Annuler");
        cancel.setStyle("-fx-background-color: #ff0000");
        cancel.setAlignment(Pos.BOTTOM_RIGHT);

        EventHandler<ActionEvent> eventCancel = e -> popup.hide();

        cancel.setOnAction(eventCancel);

        VBox root = new VBox();
        root.setPadding(new Insets(20));
        root.setSpacing(10);
        root.setStyle("-fx-background-color: #ffffff");
        root.setAlignment(Pos.CENTER);
        root.getChildren().addAll(label, datePicker, validate, cancel);

        popup.getContent().add(root);
        popup.show(mainPane.getScene().getWindow());
    }

    @FXML
    private void endDatePopup(ActionEvent event){
        Popup popup = new Popup();

        Label label = new Label("Choisissez la nouvelle date");
        label.setTextAlignment(TextAlignment.CENTER);
        label.setLayoutY(10);

        DatePicker datePicker = new DatePicker();
        datePicker.setValue(project.getStartDate().toLocalDate());

        Button validate = new Button("Valider");
        validate.setStyle("-fx-background-color: #08f008");
        validate.setAlignment(Pos.BOTTOM_LEFT);

        EventHandler<ActionEvent> eventValidate = e -> {
            modifyEndDate(datePicker.getValue());
            popup.hide();
            endDate.setText(datePicker.getValue().toString());
        };

        validate.setOnAction(eventValidate);

        Button cancel = new Button("Annuler");
        cancel.setStyle("-fx-background-color: #ff0000");
        cancel.setAlignment(Pos.BOTTOM_RIGHT);

        EventHandler<ActionEvent> eventCancel = e -> popup.hide();

        cancel.setOnAction(eventCancel);

        VBox root = new VBox();
        root.setPadding(new Insets(20));
        root.setSpacing(10);
        root.setStyle("-fx-background-color: #ffffff");
        root.setAlignment(Pos.CENTER);
        root.getChildren().addAll(label, datePicker, validate, cancel);

        popup.getContent().add(root);
        popup.show(mainPane.getScene().getWindow());
    }

    @FXML
    private void descriptionPopup(ActionEvent event){
        Popup popup = new Popup();

        Label label = new Label("Modifier votre description");
        label.setTextAlignment(TextAlignment.CENTER);
        label.setLayoutY(10);

        TextArea textArea = new TextArea();
        textArea.setPrefWidth(551);
        textArea.setPrefHeight(262);
        textArea.setText(project.getDescription());

        Button validate = new Button("Valider");
        validate.setStyle("-fx-background-color: #08f008");
        validate.setAlignment(Pos.BOTTOM_LEFT);

        EventHandler<ActionEvent> eventValidate = e -> {
            modifyDescription(textArea.getText());
            popup.hide();
            description.setText(textArea.getText());
        };

        validate.setOnAction(eventValidate);

        Button cancel = new Button("Annuler");
        cancel.setStyle("-fx-background-color: #ff0000");
        cancel.setAlignment(Pos.BOTTOM_RIGHT);

        EventHandler<ActionEvent> eventCancel = e -> popup.hide();

        cancel.setOnAction(eventCancel);

        VBox root = new VBox();
        root.setPadding(new Insets(20));
        root.setSpacing(10);
        root.setStyle("-fx-background-color: #ffffff");
        root.setAlignment(Pos.CENTER);
        root.getChildren().addAll(label, textArea, validate, cancel);

        popup.getContent().add(root);
        popup.show(mainPane.getScene().getWindow());
    }

    public void modifyStartDate(LocalDate date){
        try {
            ProjectManager projectManager = new ProjectManager();
            projectManager.updateStartDate(date, project.getId());
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }

    public void modifyEndDate(LocalDate date){
        try {
            ProjectManager projectManager = new ProjectManager();
            projectManager.updateEndDate(date, project.getId());
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }

    public void modifyDescription(String description){
        try {
            ProjectManager projectManager = new ProjectManager();
            projectManager.updateDescription(description, project.getId());
        } catch (SQLException throwable) {
            throwable.printStackTrace();
        }
    }
}

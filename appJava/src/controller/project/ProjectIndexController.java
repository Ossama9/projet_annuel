package controller.project;

import controller.ControllerOne;
import persistence.Project;

public class ProjectIndexController extends ControllerOne {

    public Project project;

    public void initData(Project project){
        this.project = project;
    }
}

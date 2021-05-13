define(
    [
        'jquery',
        'uiComponent',
        'ko',
        'mage/url',
        'Magento_Ui/js/modal/modal',
    ], function ($, Component, ko, urlBuilder, modal) {
        'use strict';


        return Component.extend({
            defaults: {
                template: 'Dtn_ManageJob/job_form',
            },

            workDate: ko.observable(""),
            workToDo: ko.observable(""),
            dataArr: ko.observableArray(),
            ajaxData: ko.observableArray(),
            convertData: ko.observableArray(),
            checkedValue: ko.observableArray(),
            removedValue: ko.observableArray(),
            editing: ko.observable(false),
            editId: ko.observable(),
            searchBox: ko.observable(""),
            currentEmployee: ko.observable(),


            initialize: function (config) {
                var self = this;
                this._super();

                let jobData = config.workData;
                self.ajaxData(jobData);

                this.selectedAllWork = ko.pureComputed({
                    read: function () {
                        // Comparing length is quick and is accurate if only items from the
                        // main array are added to the selected array.
                        return self.checkedValue().length === self.ajaxData().length;
                    },
                    write: function (value) {
                        this.checkedValue(value ? self.ajaxData.slice(0) : []);
                    },
                    owner: this
                });

                self.editWork = function () {
                    self.workDate(this.work_time);
                    self.workToDo(this.work_to_do);
                    self.editId = this.entity_id;
                }
            },

            addButton: function () {
                this.workDate('');
                this.workToDo('');
                this.editId('');
            },

            addData: function () {
                var self = this;
                $.ajax({
                    showLoader: true,
                    url: urlBuilder.build('managejob/employee/save'),
                    data: {timeJob: self.workDate(), work: self.workToDo(), editVal: self.editId},
                    type: "POST",
                    dataType: 'json'
                }).done(function (data) {
                    if (data['action'] === 'save') {
                        self.ajaxData.push(data['data']);
                    } else if (data['action'] === 'edit') {
                        self.ajaxData(data['data']);
                    }
                }).fail(function (data) {
                    alert("Failed");
                });
            },

            remove: function () {
                var self = this;
                $.ajax({
                    showLoader: true,
                    url: urlBuilder.build('managejob/employee/delete'),
                    data: {deleteData: self.checkedValue()},
                    type: "POST",
                    dataType: 'json'
                }).done(function (data) {
                    if (data['status'] === true) {
                        self.ajaxData(data['data']);
                    }
                }).fail(function (data) {
                    alert("Failed");
                });
            },
        })
    }
);
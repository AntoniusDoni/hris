import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import SelectedInputEmployee from "../Employee/SelectionInput";
import { isEmpty } from "lodash";
import FormInputDate from "@/Components/FormInputDate";

export default function FormModal(props) {
    const { modalState } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            date_start: "",
            date_end: "",
            // is_approve: "0",
            responsible_empoyee_id:"",
        });
    const status = [{ value: "tetap" }];
    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type === "checkbox"
                ? event.target.checked
                    ? 1
                    : 0
                : event.target.value
        );
    };

    const handleReset = () => {
        modalState.setData(null);
        reset();
        clearErrors();
    };

    const handleClose = () => {
        handleReset();
        modalState.toggle();
    };

    const handleSubmit = () => {
        const leave = modalState.data;
        if (leave !== null) {
            console.log(leave);
            put(route("leave.update", leave), {
                onSuccess: () => handleClose(),
            });
            return;
        }
        // post(route("leave.store"), {
        //     onSuccess: () => handleClose(),
        // });
    };

    useEffect(() => {
        const leave = modalState.data;
        if (isEmpty(leave) === false) {

            setData({
                date_start: leave.date_start,
                date_end: leave.date_end,
                // is_approve: "tetap",
                responsible_empoyee_id:leave.responsible_empoyee_id,
            });
            return;
        }
    }, [modalState]);

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Pegawai"}
            maxW="8"
        >
                    <FormInputDate
                        name="date_start"
                        selected={data.date_start}
                        onChange={(date) => setData("date_start", date)}
                        label="Tanggal Mulai"
                        error={errors.date_start}
                    />
                    <FormInputDate
                        name="date_end"
                        selected={data.date_end}
                        onChange={(date) => setData("date_end", date)}
                        label="Tanggal Selesai"
                        error={errors.date_end}
                    />
                    <SelectedInputEmployee
                         label="Penanggung Jawab"
                         itemSelected={data.responsible_empoyee_id}
                         onItemSelected={(id) =>
                             setData("responsible_empoyee_id", id)
                         }
                         error={errors.responsible_empoyee_id}
                    />

            <div className="flex items-center">
                <Button onClick={handleSubmit} processing={processing}>
                    Simpan
                </Button>
                <Button onClick={handleClose} type="secondary">
                    Batal
                </Button>
            </div>
        </Modal>
    );
}

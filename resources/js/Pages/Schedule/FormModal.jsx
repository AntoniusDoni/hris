import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";
import { isEmpty } from "lodash";


export default function FormModal(props) {
    const { modalState } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            name: "",
            start_in: "",
            end_out: "",
        });

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
        const scheduler = modalState.data;
        if (scheduler !== null) {
            put(route("scheduler.update", scheduler), {
                onSuccess: () => handleClose(),
            });
            return;
        }
        post(route("scheduler.store"), {
            onSuccess: () => handleClose(),
        });
    };

    useEffect(() => {
        const scheduler = modalState.data;
        if (isEmpty(scheduler) === false) {
            setData({
                name: scheduler.name,
                start_in: scheduler.start_in,
                end_out: scheduler.end_out,
            });
            return;
        }
    }, [modalState]);

    return (
        <Modal isOpen={modalState.isOpen} toggle={handleClose} title={"Jadwal"}>
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="Nama"
                error={errors.name}
            />
            <FormInput
                type={"time"}
                name="start_in"
                value={data.start_in}
                onChange={handleOnChange}
                label="Jam Masuk"
                error={errors.start_in}
                
            />
            <FormInput
                type={"time"}
                name="end_out"
                value={data.end_out}
                onChange={handleOnChange}
                label="Jam Pulang"
                error={errors.end_out}
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

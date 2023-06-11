import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import { isEmpty } from "lodash";
import FormInputDate from "@/Components/FormInputDate";
import SelectInputEmployee from "../Employee/SelectionInput";
import FormInput from "@/Components/FormInput";

export default function FormModal(props) {
    const { modalState } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            date_at: new Date(),
            employee_id: "",
            time_attendance: "",
            is_attendance: "1",
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
        const employee = modalState.data;
        if (employee !== null) {
            put(route("attendance.update", employee), {
                onSuccess: () => handleClose(),
            });
            return;
        }
        post(route("attendance.store"), {
            onSuccess: () => handleClose(),
        });
    };

    useEffect(() => {
        const employee = modalState.data;
        if (isEmpty(employee) === false) {
            setData({
                date_at: "",
                employee_id: "",
                time_attendance: "",
                is_attendance: "",
            });
            return;
        }
    }, [modalState]);

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Absensi"}
        >
            <SelectInputEmployee
                label="Pegawai"
                itemSelected={data.employee_id}
                onItemSelected={(id) => setData("employee_id", id)}
                error={errors.employee_id}
            />
            <FormInputDate
                name="date_at"
                selected={data.date_at}
                onChange={(date) => setData("date_at", date)}
                label="Tanggal"
                error={errors.date_at}
            />
            <div className="flex-auto">
                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Absensi
                </label>
                <select
                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                    name="is_attendance"
                    onChange={handleOnChange}
                    value={data.is_attendance}
                >
                    <option value={"1"}>Absen Masuk </option>
                    <option value={"2"}>Absen Pulang</option>
                </select>
            </div>
            <FormInput
                type={"time"}
                name="time_attendance"
                value={data.time_attendance}
                onChange={handleOnChange}
                label="Jam "
                error={errors.time_attendance}
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

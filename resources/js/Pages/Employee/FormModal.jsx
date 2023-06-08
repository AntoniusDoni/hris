import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";
import SelectedInputDevision from "../Division/SelectionInput";
import SeletedInputPosition from "../Position/SelectionInput";
import { isEmpty } from "lodash";
import FormInputDate from "@/Components/FormInputDate";

export default function FormModal(props) {
    const { modalState } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            name: "",
            division_id: "",
            position_id: "",
            nip: "",
            password: "",
            profile_image: "",
            email: "",
            phone: "",
            address: "",
            date_in: "",
            date_out: "",
            employee_status: "tetap",
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
        const employee = modalState.data;
        if (employee !== null) {
            put(route("employee.update", employee), {
                onSuccess: () => handleClose(),
            });
            return;
        }
        post(route("employee.store"), {
            onSuccess: () => handleClose(),
        });
    };

    useEffect(() => {
        const employee = modalState.data;
        if (isEmpty(employee) === false) {
            setData({
                name: employee.name,
                division_id: employee.division_id,
                position_id: employee.position_id,
                nip: employee.nip,
                password: employee.password,
                profile_image: employee.profile_image,
                email: employee.email,
                phone: employee.phone,
                address: employee.address,
                date_in: employee.date_in,
                date_out: employee.date_out,
                employee_status: employee.employee_status,
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
            <div className="flex">
                <div className="flex-none px-2">
                    <FormInput
                        name="nip"
                        value={data.nip}
                        onChange={handleOnChange}
                        label="NIP"
                        error={errors.nip}
                    />
                </div>
                <div className="flex-auto px-2">
                    <FormInput
                        name="name"
                        value={data.name}
                        onChange={handleOnChange}
                        label="Nama"
                        error={errors.name}
                    />
                </div>
                
            </div>
            <div className="flex">
                <div className="flex-auto px-2">
                    <SelectedInputDevision
                        label="Divisi"
                        itemSelected={data.division_id}
                        onItemSelected={(id) => setData("division_id", id)}
                        error={errors.division_id}
                    />
                </div>
                <div className="flex-auto px-2">
                    <SeletedInputPosition
                        label="Jabatan"
                        itemSelected={data.position_id}
                        onItemSelected={(id) => setData("position_id", id)}
                        error={errors.position_id}
                    />
                </div>
                <div className="flex-auto px-2">
                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Status Pegawai
                    </label>
                    <select
                        className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                        name="employee_status"
                        onChange={handleOnChange}
                        value={data.employee_status}
                    >
                        
                        <option value={"tetap"}>PKTT</option>
                        <option value={"kontrak"}>PKWT</option>
                    </select>
                </div>
            </div>
            <div className="flex">
                <div className="flex-none w-64 px-2">
                    <FormInput
                        name="email"
                        value={data.email}
                        onChange={handleOnChange}
                        label="Email"
                        type={"email"}
                        error={errors.email}
                    />
                </div>
                <div className="flex-none w-64 px-2">
                    <FormInput
                        name="phone"
                        value={data.phone}
                        onChange={handleOnChange}
                        label="Telpone"
                        error={errors.phone}
                    />
                </div>
                <div className="flex-none w-64 px-2">
                    <FormInput
                        name="password"
                        value={data.password}
                        onChange={handleOnChange}
                        label="Kata Sandi"
                        type={"password"}
                        error={errors.password}
                    />
                </div>
                <div className="flex-none w-64 px-2">
                    <FormInputDate
                        name="date_in"
                        selected={data.date_in}
                        onChange={(date) => setData("date_in", date)}
                        label="Tanggal Masuk"
                        error={errors.date_in}
                    />
                </div>
                <div className="flex-none w-64 px-2">
                    <FormInputDate
                        name="date_out"
                        selected={data.date_out}
                        onChange={(date) => setData("date_out", date)}
                        label="Tanggal Keluar"
                        error={errors.date_out}
                    />
                </div>
            </div>
            <div className="flex">
                
                <div className="flex-auto px-2">
                    <FormInput
                        name="address"
                        value={data.address}
                        onChange={handleOnChange}
                        label="Alamat"
                        error={errors.address}
                    />
                </div>
            </div>
           

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

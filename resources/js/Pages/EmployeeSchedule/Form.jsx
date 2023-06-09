import React, { useEffect } from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Button from "@/Components/Button";
import SelectedInputDevision from "../Division/SelectionInput";
import SeletedInputPosition from "../Position/SelectionInput";
import SelectEmployee from "../Employee/SelectionInput"
import SelectInputSchedule from "../Schedule/SelectionInput"

export default function Form(props) {
    const { modalState } = props;
    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm({
            employee_id: "",
            division_id: "",
            position_id: "",
            schedules_id: "",
            date: "",
            long_day: 5,
            employee_var: 0,
            is_employee: false,

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
    const handleOnChangeEmployee = (event) => {
        if (event.target.value == 1) {
            setData({ employee_var: event.target.value, is_employee: true,division_id:data.division_id,position_id:data.position_id,schedules_id:data.schedules_id })
        } else {
            setData({ employee_var: event.target.value, is_employee: false,division_id:data.division_id,position_id:data.position_id,schedules_id:data.schedules_id})
        }
    }
    const handleSubmit = () => {
        const employeeScheduler = modalState.data;
        if (employeeScheduler !== null) {
            put(route("employee-scheduler.update", employeeScheduler), {
                onSuccess: () => handleClose(),
            });
            return;
        }
        post(route("employee-scheduler.store"), {
            onSuccess: () => handleClose(),
        });
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            flash={props.flash}
            page={"Dashboard"}
            action={"Jadwal Pegawai"}
        >
            <Head title={"Jadwal Pegawai"} />

            <div>
                <div className="mx-auto sm:px-6 lg:px-8">
                    <div className="overflow-hidden p-4 shadow-sm sm:rounded-lg bg-white dark:bg-gray-800 flex flex-col ">
                        <div className="text-xl mb-4">Jadwal Pegawai</div>
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
                                <SelectInputSchedule
                                    label="Jadwal"
                                    itemSelected={data.schedules_id}
                                    onItemSelected={(id) => setData("schedules_id", id)}
                                    error={errors.schedules_id}
                                />
                            </div>
                            <div className="flex-auto px-2">
                                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Jenis Pegawai
                                </label>
                                <select
                                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                                    name="employee_var"
                                    onChange={handleOnChangeEmployee}
                                    value={data.employee_var}
                                >
                                    <option value={"0"}>-- Semua Peagawai --</option>
                                    <option value={"1"}>Pilih Pegawai</option>
                                </select>
                            </div>
                        </div>
                        <div className="flex">
                            <div className="flex-auto px-2">
                                <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Jumlah Hari Kerja
                                </label>
                                <select
                                    className="mb-2 bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white"
                                    name="long_day"
                                    onChange={handleOnChange}
                                    value={data.long_day}
                                >
                                    <option value={"5"}>5 Hari </option>
                                    <option value={"6"}>6 Hari</option>
                                </select>
                            </div>
                            {
                                data.is_employee == true && (
                                    <div className="flex-auto px-2">
                                        <SelectEmployee
                                            label="Pegawai"
                                            itemSelected={data.employee_id}
                                            onItemSelected={(id) => setData("employee_id", id)}
                                            error={errors.employee_id}
                                        />
                                    </div>
                                )
                            }
                        </div>

                        <div className="mt-10">
                            <Button
                                onClick={handleSubmit}
                                processing={processing}
                            >
                                Simpan
                            </Button>
                        </div>
                    </div>
                </div>
            </div>

        </AuthenticatedLayout>
    );
}

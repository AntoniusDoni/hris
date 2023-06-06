import React, { useEffect } from "react";
import Modal from "@/Components/Modal";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Button";
import FormInput from "@/Components/FormInput";
import ParentInputDevision from "./SelectionInput"
import { isEmpty } from "lodash";

export default function FormModal(props) {
    const { modalState } = props
    const { data, setData, post, put, processing, errors, reset, clearErrors } = useForm({
        name: '',
        division_parent_id: '',
    })

    const handleOnChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? (event.target.checked ? 1 : 0) : event.target.value);
    }

    const handleReset = () => {
        modalState.setData(null)
        reset()
        clearErrors()
    }

    const handleClose = () => {
        handleReset()
        modalState.toggle()
    }

    const handleSubmit = () => {
        const division = modalState.data
        if(division !== null) {
            put(route('division.update', division), {
                onSuccess: () => handleClose(),
            })
            return
        } 
        post(route('division.store'), {
            onSuccess: () => handleClose()
        })
    }

    useEffect(() => {
        const division = modalState.data
        if (isEmpty(division) === false) {
            setData({
                name: division.name,
                division_parent_id: division.division_parent_id,
            })
            return 
        }
    }, [modalState])

    return (
        <Modal
            isOpen={modalState.isOpen}
            toggle={handleClose}
            title={"Divisi"}
        >
            <FormInput
                name="name"
                value={data.name}
                onChange={handleOnChange}
                label="Nama"
                error={errors.name}
            />
            <ParentInputDevision 
                 label="Parent"
                 itemSelected={data.division_parent_id}
                 onItemSelected={(id) => setData('division_parent_id', id)}
                 error={errors.division_parent_id}
            />
            <div className="flex items-center">
                <Button
                    onClick={handleSubmit}
                    processing={processing} 
                >
                    Simpan
                </Button>
                <Button
                    onClick={handleClose}
                    type="secondary"
                >
                    Batal
                </Button>
            </div>
        </Modal>
    )
}
import { Button, ButtonProps } from "@/components/ui/button";
import { useForm } from "./form";

export type FormSubmitProps = ButtonProps;

function FormSubmit({ ...props }: FormSubmitProps) {
  const { id } = useForm();

  return <Button form={id} type="submit" {...props} />;
}

export default FormSubmit;

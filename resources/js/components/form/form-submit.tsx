import { ButtonRoot } from "@narsil-cms/components/button";

import useForm from "./form-context";

type FormSubmitProps = React.ComponentProps<typeof ButtonRoot> & {};

function FormSubmit({ ...props }: FormSubmitProps) {
  const { id } = useForm();

  return <ButtonRoot form={id} type="submit" {...props} />;
}

export default FormSubmit;

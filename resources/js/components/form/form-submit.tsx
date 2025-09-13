import { Button } from "@narsil-cms/components/button";

import useForm from "./form-context";

type FormSubmitProps = React.ComponentProps<typeof Button> & {};

function FormSubmit({ ...props }: FormSubmitProps) {
  const { id } = useForm();

  return <Button form={id} type="submit" {...props} />;
}

export default FormSubmit;

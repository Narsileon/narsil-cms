import { Button } from "@narsil-cms/components/ui/button";
import { cn } from "@narsil-cms/lib/utils";
import useForm from "./form-context";

type FormSubmitProps = React.ComponentProps<typeof Button> & {};

function FormSubmit({ className, ...props }: FormSubmitProps) {
  const { id } = useForm();

  return (
    <Button
      className={cn("col-span-full", className)}
      form={id}
      type="submit"
      {...props}
    />
  );
}

export default FormSubmit;

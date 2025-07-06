import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import useForm from "./form-context";
import type { ButtonProps } from "@/components/ui/button";

export type FormSubmitProps = ButtonProps;

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

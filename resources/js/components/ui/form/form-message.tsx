import { cn } from "@/lib/utils";
import useFormField from "./form-field-context";

export type FormMessageProps = React.ComponentProps<"p">;

function FormMessage({ className, ...props }: FormMessageProps) {
  const { error } = useFormField();

  if (!error) {
    return null;
  }

  return (
    <p
      data-slot="form-message"
      className={cn("text-destructive text-sm", className)}
      {...props}
    >
      {error}
    </p>
  );
}

export default FormMessage;

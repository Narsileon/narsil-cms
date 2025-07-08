import { cn } from "@/lib/utils";

type FormDescriptionProps = React.ComponentProps<"p"> & {};

function FormDescription({ className, ...props }: FormDescriptionProps) {
  return (
    <p
      data-slot="form-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default FormDescription;

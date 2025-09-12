import { cn } from "@narsil-cms/lib/utils";

type FormDescriptionProps = React.ComponentProps<"p"> & {};

function FormDescription({ className, ...props }: FormDescriptionProps) {
  return (
    <p
      data-slot="form-description"
      className={cn("text-sm text-muted-foreground", className)}
      {...props}
    />
  );
}

export default FormDescription;

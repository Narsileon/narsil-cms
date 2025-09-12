import { cn } from "@narsil-cms/lib/utils";

type FormItemProps = React.ComponentProps<"div"> & {};

function FormItem({ className, ...props }: FormItemProps) {
  return (
    <div
      data-slot="form-item"
      className={cn("col-span-full flex flex-col gap-2", className)}
      {...props}
    />
  );
}

export default FormItem;

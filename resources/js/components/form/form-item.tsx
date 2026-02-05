import { cn } from "@narsil-ui/lib/utils";
import { type ComponentProps } from "react";

type FormItemProps = ComponentProps<"div"> & {
  width?: number;
};

function FormItem({ className, width, ...props }: FormItemProps) {
  const widthClassName = getWidthClassName(width);

  return (
    <div
      data-slot="form-item"
      className={cn(
        "flex min-h-9 max-w-full flex-col gap-1 overflow-hidden [.flex-row]:items-center [.flex-row-reverse]:items-center",
        widthClassName,
        className,
      )}
      {...props}
    />
  );
}

export default FormItem;

function getWidthClassName(width?: number) {
  switch (width) {
    case 25:
      return "col-span-3";
    case 33:
      return "col-span-4";
    case 50:
      return "col-span-6";
    case 67:
      return "col-span-8";
    case 75:
      return "col-span-9";
    case 100:
    default:
      return "col-span-full";
  }
}

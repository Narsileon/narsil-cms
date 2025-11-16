import { cn } from "@narsil-cms/lib/utils";
import type { Field } from "@narsil-cms/types";
import { type ComponentProps } from "react";
import FormRenderer from "./form-renderer";

type FormPublishProps = ComponentProps<"div"> & {
  fields: Field[];
};

function FormPublish({ className, fields, ...props }: FormPublishProps) {
  return (
    <div className={cn("flex flex-col gap-4", className)} {...props}>
      {fields.map((field) => {
        return <FormRenderer key={field.handle} {...field} />;
      })}
    </div>
  );
}

export default FormPublish;

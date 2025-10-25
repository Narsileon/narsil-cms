import { VisitOptions } from "@inertiajs/core";
import { cn } from "@narsil-cms/lib/utils";
import { debounce } from "lodash";
import { useCallback, useEffect, useRef, type ComponentProps } from "react";
import useForm from "./form-context";

type FormRootProps = Omit<ComponentProps<"form">, "autoSave"> & {
  autoSave?: boolean;
  options?: Omit<VisitOptions, "data">;
};

function FormRoot({ autoSave, className, options, ...props }: FormRootProps) {
  const { action, data, id, isDirty, method, post, transform } = useForm();

  const isInitialized = useRef(false);

  const onSubmit = useCallback(
    (event?: React.FormEvent, autoSave?: boolean) => {
      event?.preventDefault();

      switch (method) {
        case "patch":
        case "put":
          transform?.((data) => ({
            ...data,
            _autoSave: autoSave,
            _dirty: isDirty,
            _method: method,
          }));
          post?.(action, { ...options, forceFormData: true });
          break;
        case "post":
          post?.(action, options);
          break;
      }
    },
    [action, isDirty, method, options, post, transform],
  );

  useEffect(() => {
    if (!autoSave) {
      return;
    }

    if (!isInitialized.current) {
      isInitialized.current = true;

      return;
    }

    const debounced = debounce(() => {
      if (isDirty) {
        onSubmit(undefined, true);
      }
    }, 500);

    debounced();

    return () => debounced.cancel();
  }, [autoSave, data, isDirty, onSubmit]);

  return (
    <form
      id={id}
      className={cn("grid", className)}
      action={action}
      method={method}
      onSubmit={onSubmit}
      {...props}
    />
  );
}

export default FormRoot;

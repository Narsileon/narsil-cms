import * as React from "react";
import Input from "./input";

type InputFileProps = Omit<React.ComponentProps<typeof Input>, "onChange"> & {
  value: File | string | undefined;
  onChange: (value: any) => void;
};

function InputFile({
  accept,
  children,
  value,
  onChange,
  ...props
}: InputFileProps) {
  const [preview, setPreview] = React.useState<string | null>(null);

  React.useEffect(() => {
    if (!value) {
      setPreview(null);

      return;
    }

    if (typeof value === "string") {
      setPreview(value);

      return;
    }

    if (value.type.startsWith("image/")) {
      const objectUrl = URL.createObjectURL(value);

      setPreview(objectUrl);

      return () => {
        URL.revokeObjectURL(objectUrl);
        setPreview(null);
      };
    }

    setPreview(null);
  }, [value]);

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.files && event.target.files.length > 0) {
      onChange(event.target.files[0]);
    }
  };

  return (
    <Input accept={accept} type="file" onChange={handleChange} {...props}>
      {value && preview ? (
        <img src={preview} className="size-5 rounded" />
      ) : (
        children
      )}
    </Input>
  );
}

export default InputFile;
